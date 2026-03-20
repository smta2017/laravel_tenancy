<?php

namespace App\Http\Controllers\API\Central;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Plan;
use Illuminate\Support\Str;

class PlanController extends AppBaseController
{
    public function index()
    {
        $plans = Plan::with(['features' => fn($q) => $q->withTrashed()])->orderBy('sort_order', 'asc')->get();
        return $this->sendResponse($plans, 'Plans retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'invoice_period' => 'required|integer',
            'invoice_interval' => 'required|string|in:day,week,month,year',
            'trial_period' => 'integer',
            'trial_interval' => 'string|in:day,week,month,year',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'features.*.id' => 'nullable|integer',
            'features.*.name' => 'required|string',
            'features.*.slug' => 'required|string',
            'features.*.value' => 'required|string',
            'features.*.description' => 'nullable|string',
            'features.*.sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $plan = Plan::create($validated);

        if ($request->has('features')) {
            $featuresDat = $request->input('features', []);
            foreach ($featuresDat as $featureData) {
                if (empty($featureData['name'])) continue;
                $plan->features()->create([
                    'name' => $featureData['name'],
                    'value' => $featureData['value'],
                    'description' => $featureData['description'] ?? '',
                    'sort_order' => $featureData['sort_order'] ?? 0,
                    'code' => $featureData['slug']
                ]);
            }
        }

        return $this->sendResponse($plan->load(['features' => fn($q) => $q->withTrashed()]), 'Plan created successfully');
    }

    public function show($id)
    {
        $plan = Plan::with(['features' => fn($q) => $q->withTrashed()])->find($id);
        if (!$plan) return $this->sendError('Plan not found');
        return $this->sendResponse($plan, 'Plan retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);
        if (!$plan) return $this->sendError('Plan not found');

        $validated = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'currency' => 'string|size:3',
            'invoice_period' => 'integer',
            'invoice_interval' => 'string|in:day,week,month,year',
            'trial_period' => 'integer',
            'trial_interval' => 'string|in:day,week,month,year',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'features' => 'nullable|array',
            'features.*.id' => 'nullable|integer',
            'features.*.name' => 'required|string',
            'features.*.slug' => 'required|string',
            'features.*.value' => 'required|string',
            'features.*.description' => 'nullable|string',
            'features.*.sort_order' => 'nullable|integer',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $plan->update($validated);

        if ($request->has('features')) {
            $incomingFeatureIds = [];
            $featuresDat = $request->input('features', []);

            foreach ($featuresDat as $featureData) {
                if (empty($featureData['name'])) continue;
                
                $feature = $plan->features()->withTrashed()->updateOrCreate(
                    ['id' => $featureData['id'] ?? null],
                    [
                        'name' => $featureData['name'],
                        'value' => $featureData['value'],
                        'description' => $featureData['description'] ?? '',
                        'sort_order' => $featureData['sort_order'] ?? 0,
                        'code' => $featureData['slug']
                    ]
                );

                if ($feature->trashed()) {
                    $feature->restore();
                }

                $incomingFeatureIds[] = $feature->id;
            }

            // Remove features that were deleted (Soft Delete)
            $plan->features()->whereNotIn('id', $incomingFeatureIds)->delete();
        }

        return $this->sendResponse($plan->load(['features' => fn($q) => $q->withTrashed()]), 'Plan updated successfully');
    }

    public function destroy($id)
    {
        $plan = Plan::find($id);
        if (!$plan) return $this->sendError('Plan not found');

        $plan->delete();
        return $this->sendResponse($id, 'Plan deleted successfully');
    }
}
