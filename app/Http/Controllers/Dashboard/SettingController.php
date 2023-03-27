<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\SettingUpdateRequest;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $setting->update($request->validated());
        $imagename = date('Y-m-d') . '.' . $request->logo->extension();
        $logo = Image::make($request->logo->path());
        $logo->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        })->stream();
        // Storage::disk('public')->put($imagename, $logo);
        $request->logo->move(public_path('Attachments/' . $imagename), $imagename);
        $setting->update(['logo' => 'public/' . $imagename]);
        return redirect()->route('dashboard.settings.index')->with('success', 'تم تحديث الاعدادات بنجاح');
    }
}
