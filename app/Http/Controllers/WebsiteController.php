<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
	public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:header_setup'])->only('header');
        $this->middleware(['permission:footer_setup'])->only('footer');
        $this->middleware(['permission:view_all_website_pages'])->only('pages');
        $this->middleware(['permission:website_appearance'])->only('appearance');
    }

	public function header(Request $request)
	{
		return view('backend.website_settings.header');
	}
	public function footer(Request $request)
	{
		$lang = $request->lang;
		return view('backend.website_settings.footer', compact('lang'));
	}
	public function pages(Request $request)
	{
		return view('backend.website_settings.pages.index');
	}
	public function appearance(Request $request)
	{
		return view('backend.website_settings.appearance');
	}
	public function defaultRef()
	{
        $code = BusinessSetting::where('type','default_ref')->value('value');
		return view('backend.website_settings.edit_default_ref_code',compact('code'));
	}

	public function saveDefaultRef(Request $request){
        $code = BusinessSetting::where('type','default_ref')->first();
        $code->value = $request->ref_code;
        $code->save();
        flash(translate("Default Ref. Code updated successfully"))->success();
        return redirect(route('admin.dashboard'));
    }

}
