<?php

namespace App\repository;

use App\storage\Database;

class User
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getOne($id)
    {
        $json = $this->db->getData();
        $taskList = json_decode($json, TRUE);
        foreach ($taskList as $key => $value) {
            if (!in_array($id, $value)) {
                return json_encode([
                    'code' => 1,
                    'message' => 'not find',
                ]);
            }
        }
        return json_encode($taskList[$id]);
    }

    public function getAll()
    {
        return $this->db->getData();
    }

    public function save($request)
    {
        $curLastId = json_decode($this->getLastId());
        $parsedRequest = $request->getParsedBody();
        $newname = $parsedRequest["name"];
        $file = $this->db->getData();
        $taskList = json_decode($file, TRUE);
        $taskList[] = array('id' => $curLastId + 1, 'name' => $newname);
        $this->db->putData($taskList);
        return $taskList;
    }

    public function delete($id)
    {
        $file = file_get_contents('../users.json');
        $taskList = json_decode($file, TRUE);
        foreach ($taskList as $key => $value) {
            if (in_array($id, $value)) {
                unset($taskList[$id]);
            }
        }
        file_put_contents('../users.json', json_encode($taskList));
        unset($taskList);
    }

    public function update($request, $id)
    {
        $oldname = json_decode($this->getOne($id));
        $parsedRequest = $request->getParsedBody();
        $newname = $parsedRequest["name"];
        $file = file_get_contents('../users.json');
        $taskList = json_decode($file, TRUE);
        foreach ($taskList as $key => $value) {
            if ($oldname->name == $value["name"]) {
                $taskList[$key] = array('id' => $oldname->id, 'name' => $newname);
            }
        }
        file_put_contents('../users.json', json_encode($taskList));
        return $taskList;
    }

    private function getLastId()
    {
        $json = $this->db->getData();
        $position = count(json_decode($json));
        $lastId = json_decode($json)[$position - 1];
        return $lastId->id;
    }

}