<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit_header()
    {
        $setting = HeaderSetting::firstOrCreate(['id' => 1]);
        return view('admin.setting.header.edit', compact('setting'));
    }

    public function update_header(Request $request)
    {
        $setting = HeaderSetting::firstOrFail();

        $setting->update([
            'topbar_email_icon' => $request->topbar_email_icon,
            'topbar_email_text' => $request->topbar_email_text,
            'topbar_email_link' => $request->topbar_email_link,
            'topbar_phone_icon' => $request->topbar_phone_icon,
            'topbar_phone_text' => $request->topbar_phone_text,
            'topbar_phone_link' => $request->topbar_phone_link,
            'sitename_text' => $request->sitename_text,
            'sitename_href' => $request->sitename_href,
            'navbar_items' => $request->navbar_items, // JSON: [{text, href, class}]
        ]);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
