<?php

namespace App\Http\Controllers\techvault;

use App\Http\Controllers\Controller;
use App\Models\techvault\EngineeringWiki;
use App\Http\Requests\content\digitize\techvault\EngineeringWikiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EngineeringWikiController extends Controller
{
    public function index(Request $request)
    {
        $query = EngineeringWiki::query();
        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('brand')) $query->where('brand', $request->brand);
        if ($request->filled('device_type')) $query->where('device_type', $request->device_type);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('priority')) $query->where('priority', $request->priority);
        $brands = EngineeringWiki::query()->distinct()->whereNotNull('brand')->pluck('brand');
        $deviceTypes = EngineeringWiki::query()->distinct()->whereNotNull('device_type')->pluck('device_type');
        $wikis = $query->orderByDesc('created_at')->paginate(15);
        return view('content.digitize.techvault.engineering_wiki.index', compact('wikis', 'brands', 'deviceTypes'));
    }

    public function create()
    {
        // Fetch reference data from engineering_wikis table itself
        $brands = EngineeringWiki::query()->distinct()->whereNotNull('brand')->pluck('brand');
        $deviceTypes = EngineeringWiki::query()->distinct()->whereNotNull('device_type')->pluck('device_type');
        $models = EngineeringWiki::query()->distinct()->whereNotNull('model')->pluck('model');
        $firmwareVersions = EngineeringWiki::query()->distinct()->whereNotNull('firmware_version')->pluck('firmware_version');
        $hardwareVersions = EngineeringWiki::query()->distinct()->whereNotNull('hardware_version')->pluck('hardware_version');

        return view('content.digitize.techvault.engineering_wiki.create', compact(
            'brands', 'deviceTypes', 'models', 'firmwareVersions', 'hardwareVersions'
        ));
    }

    public function store(EngineeringWikiRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        // Handle file and image uploads
        foreach (['symptom', 'root_cause', 'solution', 'action_taken'] as $field) {
            if ($request->hasFile($field . '_file')) {
                $data[$field . '_file'] = $request->file($field . '_file')->store('engineering_wiki/files', 'public');
            }
            if ($request->hasFile($field . '_image')) {
                $data[$field . '_image'] = $request->file($field . '_image')->store('engineering_wiki/images', 'public');
            }
        }

        EngineeringWiki::create($data);
        return redirect()->route('techvault-engineeringwiki')->with('success', 'Wiki created successfully.');
    }

    public function show(EngineeringWiki $engineeringWiki)
    {
        return view('content.digitize.techvault.engineering_wiki.show', compact('engineeringWiki'));
    }

    public function edit(EngineeringWiki $engineeringWiki)
    {
        return view('content.digitize.techvault.engineering_wiki.edit', compact('engineeringWiki'));
    }

    public function update(EngineeringWikiRequest $request, EngineeringWiki $engineeringWiki)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        // Handle file and image uploads (same as store, but delete old if new uploaded)
        foreach (['symptom', 'root_cause', 'solution', 'action_taken'] as $field) {
            if ($request->hasFile($field . '_file')) {
                if ($engineeringWiki->{$field . '_file'}) {
                    Storage::disk('public')->delete($engineeringWiki->{$field . '_file'});
                }
                $data[$field . '_file'] = $request->file($field . '_file')->store('engineering_wiki/files', 'public');
            }
            if ($request->hasFile($field . '_image')) {
                if ($engineeringWiki->{$field . '_image'}) {
                    Storage::disk('public')->delete($engineeringWiki->{$field . '_image'});
                }
                $data[$field . '_image'] = $request->file($field . '_image')->store('engineering_wiki/images', 'public');
            }
        }

        $engineeringWiki->update($data);
        return redirect()->route('techvault-engineeringwiki')->with('success', 'Wiki updated successfully.');
    }

    public function destroy(EngineeringWiki $engineeringWiki)
    {
        $engineeringWiki->delete();
        return redirect()->route('techvault-engineeringwiki')->with('success', 'Wiki deleted successfully.');
    }
}
