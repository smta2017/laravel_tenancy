<?php

namespace App\Http\Controllers\API\Central;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Feature;
use Illuminate\Support\Str;

class FeatureController extends AppBaseController
{
    public function index()
    {
        $features = Feature::orderBy('sort_order', 'asc')->get();
        return $this->sendResponse($features, 'Features retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:features,code',
            'description' => 'nullable|string',
            'value' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $feature = Feature::create($validated);

        return $this->sendResponse($feature, 'Feature created successfully');
    }

    public function show($id)
    {
        $feature = Feature::find($id);
        if (!$feature) return $this->sendError('Feature not found');
        return $this->sendResponse($feature, 'Feature retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::find($id);
        if (!$feature) return $this->sendError('Feature not found');

        $validated = $request->validate([
            'name' => 'string',
            'code' => 'string|unique:features,code,' . $id,
            'description' => 'nullable|string',
            'value' => 'string',
            'sort_order' => 'integer',
        ]);

        $feature->update($validated);

        return $this->sendResponse($feature, 'Feature updated successfully');
    }

    public function destroy($id)
    {
        $feature = Feature::find($id);
        if (!$feature) return $this->sendError('Feature not found');

        $feature->delete();
        return $this->sendResponse($id, 'Feature deleted successfully');
    }
}
