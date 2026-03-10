<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\LoginTenantRequest;
use App\Models\CentralUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends AppBaseController
{



    public function login(LoginTenantRequest $request)
    {
        // Attempt to log in the CentralUser using the credentials
        $attempt_type = is_numeric($request->identifier) ? 'phone' : 'email';
        if (Auth::attempt([$attempt_type => $request->identifier, 'password' => $request->password])) {
            $central_user = CentralUser::find($request->user()->id);
            $tenant = $central_user->Tenants->first();

            // $subscription = $tenant->planSubscription('main')->with('plan')->first();

            tenancy()->initialize($tenant);
            Auth::attempt([$attempt_type => $request->identifier, 'password' => $request->password]);
            /** @var User $tenant_user */
            $tenant_user = Auth::user();

            // Check if the user's account is verified
            if (!$tenant_user->account_verified_at) {
                return $this->sendError('Your account is not verified, please verify it first.', 403);
            }

            // Check if the user is active
            if (!$tenant_user->is_active) {
                return $this->sendError('Your account is not active, please activate it first.', 403);
            }

            $sanctum_token = $request->user()->createToken('api-login-token')->plainTextToken;

            // Return a JSON response with the token and user details
            return $this->sendUserResponse($tenant_user, 'Tenant Login successfuly', $sanctum_token);
        } else {
            // Return an error response if the login attempt failed
            return $this->sendError('Invalid credentials', 401);
        }
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     */
    public function me(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendUserResponse($user, 'User retrieved successfully');
    }

    public function updateProfileImage(\Illuminate\Http\Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        /** @var User $user */
        $user = auth()->user();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Define paths
            $folder = 'users/avatars';
            $path = $file->storeAs($folder, $filename, 'public');

            // Full path for processing
            $fullPath = storage_path('app/public/' . $path);

            // Process the image using dimensions from config
            $width = config('settings.avatar.width', 100);
            $height = config('settings.avatar.height', 100);

            try {
                $this->resizeImage($fullPath, $width, $height);
            } catch (\Exception $e) {
                // If resizing fails, we still have the original but we should log the error
                Log::error("Image resizing failed: " . $e->getMessage());
            }

            // Update user avatar
            $user->avatar = $path;
            $user->save();
        }

        // Ensure relations are loaded for UserContextTrait
        $user->load(['roles', 'permissions']);

        return $this->sendUserResponse($user, 'Profile image updated successfully');
    }

    /**
     * Resize and center crop image to specific dimensions using GD
     */
    private function resizeImage($path, $width, $height)
    {
        if (!file_exists($path)) return;

        $info = getimagesize($path);
        if (!$info) return;

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $image = imagecreatefrompng($path);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($path);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($path);
                break;
            default:
                return;
        }

        $oldWidth = imagesx($image);
        $oldHeight = imagesy($image);

        // Calculate source coordinates and dimensions for a center crop
        $srcX = 0;
        $srcY = 0;
        $srcW = $oldWidth;
        $srcH = $oldHeight;

        if ($oldWidth / $oldHeight > $width / $height) {
            // Original is wider than target
            $srcW = $oldHeight * ($width / $height);
            $srcX = ($oldWidth - $srcW) / 2;
        } else {
            // Original is taller than target
            $srcH = $oldWidth * ($height / $width);
            $srcY = ($oldHeight - $srcH) / 2;
        }

        $newImage = imagecreatetruecolor($width, $height);

        // Handle transparency for PNG/GIF/WEBP
        if ($mime == 'image/png' || $mime == 'image/gif' || $mime == 'image/webp') {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
        }

        imagecopyresampled($newImage, $image, 0, 0, $srcX, $srcY, $width, $height, $srcW, $srcH);

        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($newImage, $path, 90);
                break;
            case 'image/png':
                imagepng($newImage, $path);
                break;
            case 'image/gif':
                imagegif($newImage, $path);
                break;
            case 'image/webp':
                imagewebp($newImage, $path, 90);
                break;
        }

        imagedestroy($image);
        imagedestroy($newImage);
    }
}
