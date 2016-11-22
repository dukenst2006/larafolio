<?php

use Illuminate\Support\Facades\Artisan;

class ImagesCest
{
    public function _before(\AcceptanceTester $I)
    {
        Artisan::call('migrate:refresh');

        Artisan::call('db:seed', [
            '--class' => 'Larafolio\database\seeds\DatabaseSeeder'
        ]);
    }

    public function _after(\AcceptanceTester $I)
    {
        Artisan::call('migrate:refresh');

        Artisan::call('db:seed', [
            '--class' => 'Larafolio\database\seeds\DatabaseSeeder'
        ]);
    }

    public function user_can_add_image(AcceptanceTester $I)
    {
        $project = $I->getProject($I);
        $I->wantTo('Add an image to a project.');
        $I->login($I);
        $I->addImage($I, $project);
        $I->seeInDatabase('images', ['path' => 'public/images/411e2a002b29beb934678763a1fb9211.jpeg']);
        $I->see('Image added to project');
    }

    public function user_can_update_image_name_and_caption(AcceptanceTester $I)
    {
        $project = $I->getProject($I);

        $image = $I->getImageFromProjectArray($project);

        $data = [
            'name1' => 'image name',
            'caption1' => 'image caption'
        ];

        $I->wantTo('Add a name and caption for an image.');
        $I->login($I);
        $I->amOnProjectPage($I, $project);
        $I->fillForm($I, $data);
        $I->click('Update Image');
        $I->wait(1);
        $I->seeInDatabase('images', [
            'path' => $image->path(),
            'name' => $data['name1'],
            'caption' => $data['caption1']
        ]);
        $I->see('Image information updated');
    }

    public function user_can_remove_an_image(AcceptanceTester $I)
    {
        $project = $I->getProject($I);

        $image = $I->getImageFromProjectArray($project);

        $I->wantTo('Remove an image from a project.');
        $I->login($I);
        $I->seeInDatabase('images', ['path' => $image->path()]);
        $I->amOnProjectPage($I, $project);
        $I->click('#removeImage');
        $I->click('Remove Image');
        $I->wait(1);
        $I->dontSeeInDatabase('images', ['path' => $image->path()]);
        $I->see('Image removed from project');
    }

    public function update_button_disabled_until_name_changed(AcceptanceTester $I)
    {
        $project = $I->getProject($I);

        $I->wantTo('Be able to update an image if the name has changed.');
        $I->login($I);
        $I->amOnProjectPage($I, $project);
        $I->seeElement('.button--green', ['disabled' => 'true']);
        $I->fillField(['name' => 'name1'], 'abc');
        $I->dontSeeElement('.button--green', ['disabled' => 'true']);
    }

    public function update_button_disabled_until_caption_changed(AcceptanceTester $I)
    {
        $project = $I->getProject($I);

        $I->wantTo('Be able to update an image if the caption has changed.');
        $I->login($I);
        $I->amOnProjectPage($I, $project);
        $I->seeElement('.button--green', ['disabled' => 'true']);
        $I->fillField(['name' => 'caption1'], 'abc');
        $I->dontSeeElement('.button--green', ['disabled' => 'true']);
    }
}
