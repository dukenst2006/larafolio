<?php

namespace Larafolio\Http\Controllers;

use Larafolio\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Update image name and caption.
     *
     * @param \Illuminate\Http\Request $request Request object.
     * @param Larafolio\Models\Image   $image   Image to be updated.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $imageData = $request->only(['name', 'caption']);

        $this->user->updateImageInfo($image, $imageData);

        if ($request->ajax()) {
            return;
        }

        return back();
    }

    /**
     * Remove image from portfolio.
     *
     * @param Larafolio\Models\Image $image Image to be removed.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Image $image)
    {
        $this->user->removeImage($image);

        if ($request->ajax()) {
            return;
        }

        return back();
    }
}
