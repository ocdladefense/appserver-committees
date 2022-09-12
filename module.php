<?php

use Mysql\DbHelper;

class CommitteesModule extends Module {

    public function __construct() {

        parent::__construct();
    }


    public function list() {

        $committees = loadApi()->query("SELECT Id, Name FROM Committee__c")->getRecords();

        foreach($committees as &$committee) {
            
            $machineName = Identifier::toMachineName($committee["Name"]);
            $committee["URL"] = "/committee/$machineName";
        }

        $tpl = new Template("list");
        $tpl->addPath(__DIR__ . "/templates");
        return $tpl->render(["committees" => $committees]);
    }
    

    public function view($name) {
        
        
        $cname = Identifier::format($name, "human");
        
        $id = loadApi()->query("SELECT Id FROM Committee__c WHERE Name = '$cname'")->getRecord()["Id"];

        if(empty($id)) throw new Exception("Committee name is expected.");

        $members = $this->getMembers($id);
        $membersTemplate = new Template("members");
        $membersTemplate->addPath(__DIR__ . "/templates");
        $membersHtml = $membersTemplate->render(["members" => $members]);

        // Get the list of documents from the file service module.
        $service = new FileServiceModule();
        $docsHtml = $service->list($id);

        $page = new Template("page");
        $page->addPath(__DIR__ . "/templates");

        return $page->render([
            "committeeName" => $cname,
            "members"       => $membersHtml,
            "documents"     => $docsHtml
        ]);
    }
    

    public function getMembers($id) {

        $query = "SELECT id, Name, (SELECT Contact__r.Id, Contact__r.Title, Contact__r.Name, Role__c, Contact__r.Ocdla_Home_City__c, Contact__r.Email, Contact__r.Phone FROM Relationships__r) FROM Committee__c WHERE Id = '$id'";

        $members = loadApi()->query($query)->getRecord()["Relationships__r"]["records"];

        $contacts = [];
        foreach($members as $member) {

            $data = $member["Contact__r"];
            $contacts[$data["Id"]] = $data;
            $contacts[$data["Id"]]["role"] = $member["Role__c"];
        }

        return $contacts;
    }
}
