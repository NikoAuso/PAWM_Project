<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
 * This controller is responsible for managing
 * each user's personal profile.
 */
class ProfileController extends Controller
{
    /**
     * @var Profile
     */
    protected Profile $userModel;

    /**
     * Constructor to initialize the variable
     */
    public function __construct()
    {
        $this->userModel = new Profile();
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Return the view
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('ar/profile/profile');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function modifyData(Request $request): RedirectResponse
    {
        $this->userModel->updateProfile($request);
        return redirect()->route('profile')->with('message', 'Profilo aggiornato.');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function modifyDataSocial(Request $request): RedirectResponse
    {
        $this->userModel->updateProfileSocial($request);
        return redirect()->route('profile')->with('message', 'Profilo aggiornato.');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAvatar(Request $request): JsonResponse
    {
        $oldImage = Auth::user()->avatar;
        if ($oldImage != 'profile-1.webp'
            && $oldImage != 'profile-2.webp'
            && $oldImage != 'profile-3.webp'
            && $oldImage != 'profile-4.webp'
            && $oldImage != 'profile-5.webp'
            && $oldImage != 'profile-6.webp')
            if (Storage::disk('avatar')->exists($oldImage))
                Storage::disk('avatar')->delete($oldImage);

        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $imageName = Auth::user()->username . '_' . str_replace('.', '', microtime(true)) . ".webp";

        Storage::disk('avatar')->put($imageName, base64_decode($image));

        Profile::query()->where('id', Auth::id())->update([
            'avatar' => $imageName
        ]);

        if (Storage::disk('avatar')->exists($imageName))
            return response()
                ->json('success');
        else {
            return Response::json([
                'success' => false
            ], 500);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function deleteAvatar(): RedirectResponse
    {
        $oldImage = Auth::user()->avatar;
        if ($oldImage != 'profile-1.webp'
            || $oldImage != 'profile-2.webp'
            || $oldImage != 'profile-3.webp'
            || $oldImage != 'profile-4.webp'
            || $oldImage != 'profile-5.webp'
            || $oldImage != 'profile-6.webp') {
            if (Storage::disk('avatar')->exists($oldImage))
                Storage::disk('avatar')->delete($oldImage);
            $imageName = 'profile-' . rand(1, 6) . '.webp';
            Profile::where('id', Auth::id())->update([
                'avatar' => $imageName
            ]);
        }
        return redirect()->route('profile')
            ->with('message', 'Immagine di profilo eliminata.');
    }

    /**
     * @return Factory|View|Application
     */
    public function mostraSecurity(): Factory|View|Application
    {
        return view('ar/profile/security');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordChange(Request $request): RedirectResponse
    {
        $this->userModel->modifyPassword($request);
        return redirect()->route('logout')->with('message', 'Password modificata. Riesegui l\'accesso!');
    }
}
