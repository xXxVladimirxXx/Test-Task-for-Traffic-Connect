<?php

namespace App\Http\Controllers;

use App\Models\{Site, Server, Cdn};
use App\Services\{SiteService};
use App\Http\Requests\{StoreSiteRequest, UpdateSiteRequest};

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::with(['server', 'cdn', 'credential'])->paginate(15);

        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        $servers = Server::all();
        $cdns = Cdn::all();

        return view('sites.edit', compact('servers', 'cdns'));
    }

    public function store(StoreSiteRequest $request, SiteService $siteService)
    {
        $siteService->store($request);

        return redirect()->route('sites.index')->with('success', 'Site created');
    }

    public function show(Site $site)
    {
        $site->load(['server', 'cdn', 'credential']);

        return view('sites.show', compact('site'));
    }

    public function edit(Site $site)
    {
        $servers = Server::all();
        $cdns = Cdn::all();
        $site->load('credential');

        return view('sites.edit', compact('site', 'servers', 'cdns'));
    }

    public function update(UpdateSiteRequest $request, Site $site, SiteService $siteService)
    {
        $siteService->update($request, $site);

        return redirect()->route('sites.index')->with('success', 'Site updated');
    }

    public function check(Site $site, SiteService $siteService)
    {
        $result = $siteService->checkAuth($site);

        return back()->with('success', $result['message']);
    }

    public function destroy(Site $site)
    {
        if ($site->credential()) $site->credential()->delete();

        $site->delete();

        return redirect()->route('sites.index')->with('success', 'Site deleted');
    }
}
