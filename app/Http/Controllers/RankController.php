<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\SellerPackage;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function rank(Request $request)
    {
        $sort_search = null;
        $ranks = Rank::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $ranks = $ranks->where('rank_name', 'like', '%' . $sort_search . '%');
        }
        $ranks = $ranks->paginate(10);

        $active_ranks = Rank::where('status', 1)->get();
        return view('backend.setup_configurations.rank.index', compact('ranks', 'sort_search'));

    }

    public function create()
    {
        $pacakges=SellerPackage::get();
        return view('backend.setup_configurations.rank.create',compact('pacakges'));
    }

    public function store(Request $request)
    {

        $rank = new Rank();
        $rank->rank_name = $request->rank_name;
        $rank->percentage = $request->percentage;
        $rank->package_per_month = count($request->package_name);
        $rank->status = '1';
        if ($rank->save()) {
            flash(translate('Rank created successfully'))->success();
            return redirect()->route('rank.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return redirect()->route('rank.index');
        }
    }

    public function edit(Request $request)
    {
        $rank = Rank::findOrFail($request->id);
        return view('backend.setup_configurations.rank.edit', compact('rank'));
    }

    public function updateYourRank(Request $request)
    {
        $rank = Rank::findOrFail($request->id);
        $rank->rank_name = $request->rank_name;
        $rank->percentage = $request->percentage;
        $rank->package_per_month = $request->package_per_month;
        $rank->status = $rank->status;
        if ($rank->save()) {
            flash(translate('Rank updated successfully'))->success();
            return redirect()->route('rank.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return redirect()->route('rank.index');
        }
    }

    public function update_status(Request $request)
    {
        $rank = Rank::findOrFail($request->id);
        if ($request->status == 0) {
            if (get_setting('system_default_rank') == $rank->id) {
                return 0;
            }
        }
        $rank->status = $request->status;
        $rank->save();
        return 1;
    }
}
