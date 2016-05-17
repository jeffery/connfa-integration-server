<?php

class UpdatesCest extends BaseCest
{
    public function _before(ApiTester $I)
    {
        parent::_before($I);
    }

    public function _after(ApiTester $I)
    {
        parent::_after($I);
    }

    // tests
    public function tryToCheckUpdates(ApiTester $I)
    {
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['idsForUpdate' => []]);

        $I->haveAType(['name' => 'test']);
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['idsForUpdate' => [1]]);

        $I->haveALevel(['name' => 'beginner']);
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['idsForUpdate' => [1, 2]]);

        $I->haveATrack(['name' => 'test']);
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['idsForUpdate' => [1, 2, 3]]);

        $I->haveAnSpeaker(['first_name' => 'test', 'last_name' => 'Speaker']);
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['idsForUpdate' => [1, 2, 3, 4]]);

        $I->haveALocation(['name' => 'test']);
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['idsForUpdate' => [1, 2, 3, 4, 5]]);

    }

    public function tryToCheckUpdatesWithFeatureSince(ApiTester $I)
    {
        $since = \Carbon\Carbon::parse('+5 hour');
        $I->haveHttpHeader('If-modified-since', $since->toIso8601String());
        $I->sendGET('v2/checkUpdates');
        $I->seeResponseCodeIs(304);
    }
}
