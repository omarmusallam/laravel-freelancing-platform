<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('freelancer.profile.edit', [
            'user' => $user,
            'profile' => $user->freelancer,
        ]);
    }

    public function contracts()
    {
        $user = Auth::user();

        $contracts = $user->contracts()
            ->with(['project.user', 'proposal'])
            ->latest()
            ->paginate(10);

        $contractProjectIds = $contracts->getCollection()
            ->pluck('project_id')
            ->filter()
            ->unique()
            ->values();

        $payments = Payment::query()
            ->latest()
            ->get()
            ->filter(function (Payment $payment) use ($contractProjectIds) {
                return $contractProjectIds->contains((int) data_get($payment->data, 'project_id'));
            })
            ->groupBy(function (Payment $payment) {
                return (int) data_get($payment->data, 'project_id');
            });

        $stats = [
            'total' => $user->contracts()->count(),
            'active' => $user->contracts()->where('status', 'active')->count(),
            'completed' => $user->contracts()->where('status', 'completed')->count(),
            'terminated' => $user->contracts()->where('status', 'terminated')->count(),
        ];

        return view('freelancer.contracts.index', [
            'contracts' => $contracts,
            'paymentsByProject' => $payments,
            'stats' => $stats,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'desc' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
        ]);

        $user = Auth::user();
        $old_photo = $user->freelancer->profile_photo_path;

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filepath = $file->store('profile-photos', [
                'disk' => 'public'
            ]);

            $this->syncPublicProfilePhoto($filepath);

            $data['profile_photo_path'] = $filepath;
        }

        $user->freelancer()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        $user->forceFill([
            'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
        ])->save();

        if ($old_photo && !empty($data['profile_photo_path'])) {
            Storage::disk('public')->delete($old_photo);
            File::delete(public_path('storage/' . $old_photo));
        }

        return redirect()->route('freelancer.profile.edit')
            ->with('success', 'Profile updated');
    }

    protected function syncPublicProfilePhoto(string $filepath): void
    {
        $publicStorage = public_path('storage');

        if (is_link($publicStorage)) {
            return;
        }

        $source = Storage::disk('public')->path($filepath);
        $destination = public_path('storage/' . $filepath);

        File::ensureDirectoryExists(dirname($destination));
        File::copy($source, $destination);
    }
}
