<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\SettingUpdateRequest;
use App\Utils\ImageUpload;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $setting->update($request->validated());
        if ($request->has('logo')) {
            $logo = ImageUpload::UploadImage($request->logo, 100, 200, 'logo/');
            $setting->update(['logo' => $logo]);
        }
        if ($request->has('favicon')) {
            $favicon = ImageUpload::UploadImage($request->favicon, 32, 32, 'logo/');
            $setting->update(['favicon' => $favicon]);
        }
        return redirect()->route('dashboard.settings.index')->with('success', 'تم تحديث الاعدادات بنجاح');
    }
}
