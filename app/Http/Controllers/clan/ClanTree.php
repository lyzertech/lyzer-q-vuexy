<?php

namespace App\Http\Controllers\clan;

use App\Http\Controllers\Controller;
use App\Models\clan\clan_tree;
use Illuminate\Http\Request;

class ClanTree extends Controller
{
  public function index()
  {
    $family = clan_tree::with(['children', 'spouse'])->get();
    // dd($family);
    return view('content.lyzer.clan.clan-tree', compact('family'));
  }
  public function store(Request $request)
  {
      $data = $request->validate([
          'name' => 'required|string|max:255',
          'gender' => 'required|in:male,female',
          'parent_id' => 'nullable|exists:family_members,id',
          'spouse_id' => 'nullable|exists:family_members,id',
      ]);

      FamilyMember::create($data);
      return redirect()->route('family.index');
  }
}
