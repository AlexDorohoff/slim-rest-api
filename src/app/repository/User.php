<?php

namespace App\repository;

class User
{

    public function getOne($id)
    {
        $file = file_get_contents('../users.json');
        $taskList = json_decode($file, TRUE);
        foreach ($taskList as $key => $value) {
            if (in_array($id, $value)) {
                return json_encode($taskList[$id]);
            }
        }
        return json_encode([
            'code' => 1,
            'message' => 'error',
        ]);
    }

    public function getAll()
    {
        $json = file_get_contents('../users.json');
        if (!$json) {
            return json_encode([
                'code' => 1,
                'message' => 'error',
            ]);
        };
        return $json;
    }

    public function save($request)
    {
        $curLasrId = json_decode($this->getLastId());
        $parsedRequest = $request->getParsedBody();
        $newname = $parsedRequest["name"];
        $file = file_get_contents('../users.json');
        $taskList = json_decode($file, TRUE);

        $taskList[] = array('id' => $curLasrId + 1, 'name' => $newname);
        if (!file_put_contents('../users.json', json_encode($taskList))) {
            unset($taskList);
            return json_encode([
                'code' => 1,
                'message' => 'error',
            ]);
        };

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
        $json = $this->getAll();
        $position = count(json_decode($json));
        $lastId = json_decode($json)[$position - 1];
        return $lastId->id;
    }

}