<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Link;
use App\Http\Requests\LinkRequest;

/**
 * Class LinkController
 * @Resource("link", names={
 *     "store"="service.link.store",
 *     "index"="service.link.index",
 *     "create"="service.link.create",
 *     "destroy"="service.link.destroy",
 *     "update"="service.link.update",
 *     "show"="service.link.show",
 *     "edit"="service.link.edit",
 *     })
 * @Middleware("web")
 * @package App\Http\Controllers
 */
class LinkController extends Controller
{
    public function index()
    {
        $links = Link::orderBy('updated_at', 'desc')->paginate();
        return view('link.index', array('links' => $links));
    }

    public function create()
    {
        return view('link.create');
    }

    public function store(LinkRequest $request)
    {
        $link = Link::create($request->all());
        return redirect(route('service.link.show', array('link' => $link->id)));
    }

    public function show($id)
    {
        return view('link.show', array('link' => Link::findOrFail($id)));
    }

    public function edit($id)
    {
        return view('link.edit', array('link' => Link::findOrFail($id)));
    }

    public function update(LinkRequest $request, $id)
    {
        $link = Link::findOrFail($id);
        $link->update($request->all());
        $link->save();
        return redirect(route('service.link.show', array('link' => $link->id)));
    }

    public function destroy($id)
    {
        Link::destroy($id);
        return redirect(route('service.link.index'));
    }
}
