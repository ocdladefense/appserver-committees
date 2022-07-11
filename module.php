<?php

use Mysql\DbHelper;

class CommitteeModule extends Module {

    public function __construct() {

        parent::__construct();
    }

    public function test() {

        $committeeName = "Web Governance";

        $committeeId = loadApi()->query("Select Id FROM Committee__c WHERE Name = '$committeeName'")->getRecord()["Id"];

        $documents = $this->getCommitteeDocuments($committeeId);
        $docsTemplate = new Template("documents");
        $docsTemplate->addPath(__DIR__ . "/templates");
        $docsHtml = $docsTemplate->render(["documents" => $documents]);

        $members = $this->getCommitteeMembers($committeeId);
        $membersTemplate = new Template("members");
        $membersTemplate->addPath(__DIR__ . "/templates");
        $membersHtml = $membersTemplate->render(["members" => $members]);

        $page = new Template("page");
        $page->addPath(__DIR__ . "/templates");

        return $page->render([
            "documents" => $docsHtml,
            "members" => $membersHtml
        ]);
    }

    public function getCommitteeDocuments($committeeId) {

        $api = loadApi();

        $result = $api->query("SELECT ContentDocumentId FROM ContentDocumentLink WHERE LinkedEntityId = '$committeeId'")->getQueryResult();
        $docIds = $result->getField("ContentDocumentId");

        $format = "SELECT Id, Title, ContentSize, FileType, FileExtension FROM ContentDocument WHERE Id in (:array)";
        $query = DbHelper::parseArray($format, $docIds);
        $docs = $api->query($query)->getRecords();

        foreach($docs as &$doc) {

            $doc["fileSize"] = calculateFileSize($doc["ContentSize"]);
        }

        return $docs;
    }

    public function getCommitteeMembers($committeeId) {

        $query = "SELECT id, Name, (SELECT Contact__r.Id, Contact__r.Title, Contact__r.Name, Role__c, Contact__r.Ocdla_Home_City__c, Contact__r.Email, Contact__r.Phone FROM Relationships__r) FROM Committee__c WHERE Id = '$committeeId'";

        $memberRecords = loadApi()->query($query)->getRecord()["Relationships__r"]["records"];

        $contacts = [];
        foreach ($memberRecords as $member) {

            $data = $member["Contact__r"];
            $contacts[$data["Id"]] = $data;
            $contacts[$data["Id"]]["role"] = $member["Role__c"];
        }

        return $contacts;
    }
}