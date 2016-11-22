<?php

namespace Larafolio\database\seeds;

use Storage;
use App\User;
use Larafolio\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $filesystem = new Filesystem();

        $from = __DIR__.'/../../../tests/_data/images';

        $images = $filesystem->allFiles($from);

        foreach ($images as $key => $image) {
            $path = 'public/images/'.$image->getFilename();

            $this->moveImage($image, $path, $filesystem);

            $this->addToProject($key, $path);
        }

        chgrp(storage_path('app/public/images'), 'www-data');

        $old = umask(0);

        chmod(storage_path('app/public/images'), 0775);

        umask($old);
    }

    /**
     * Move image file to storage.
     *
     * @param \Symfony\Component\Finder\SplFileInfo $image      File info.
     * @param string                                $path       Path to move to.
     * @param /Illuminate\Filesystem\Filesystem     $filesystem
     */
    protected function moveImage($image, $path, $filesystem)
    {
        $imageFile = $filesystem->get($image->getPathname());

        Storage::put($path, $imageFile);

        $fullPath = storage_path('app/'.$path);

        chgrp($fullPath, 'www-data');
    }

    /**
     * Add image to a project.
     *
     * @param int    $key  Key from image array.
     * @param string $path Path to image.
     */
    protected function addToProject($key, $path)
    {
        $project = Project::find($key + 1);

        $user = User::find(1);

        $user->addImageToProject($project, ['path' => $path]);
    }
}
