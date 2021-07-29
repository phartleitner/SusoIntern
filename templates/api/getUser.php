<?php
// Returns User Data

$api->CSRF();

if (!isset($input["userId"]) || !isset($input["userType"])) {
    
}

$user = Model::getInstance()->getUserById($input["userId"]);



$data = array();

$data = array_merge($data, $user->getData());
$data["type"] = $userType;



switch ($userType) {
    case "Guardian":
        $children = [];
        foreach($user->getChildren() as $child) {
            $teachers = [];
            foreach($child->getTeachers() as $teacher) {
                array_push($teachers, [
                    "surname" => $teacher->getSurname(),
                    "name" => $teacher->getName(),
                    "email" => $teacher->getEmail()
                ]);
            }
            array_push($children, [
                "name" => $child->getName(),
                "surname" => $child->getSurname(),
                "class" => $child->getClass(),
                "teachers" => $teachers,
                "email" => "" // No Mail addresses stored for students??????//
            ]);
        }
        $data = array_merge($data, [
            "id"=>$user->getId(),
            "children"=>$children,
            "parentId"=>$user->getParentId(),
            "appointments"=> $user->getAppointments(),
            "appointmentTeachers" => $user->getAppointmentTeachers()
        ]);
        break;
    case "Teacher":
        $data = array_merge($data, [
            "untisName"=>$user->getUntisName(),
            "lessonAmount"=>$user->getLessonAmount(),
            "taughtPupil"=>$user->getAllTaughtPupilsByName()
        ]);
        break;
    case "Student":
        $data = array_merge($data, $user->getData());



        $teachers = [];
        foreach($user->getTeachers() as $teacher) {
            array_push($teachers, [
                "surname" => $teacher->getSurname(),
                "name" => $teacher->getName(),
                "email" => $teacher->getEmail(),

            ]);
        }

        if ($user->getParentObj() !== null) {
            $data["parent"] = [
                "eid" => $user->getParentObj()->getParentId(),
                "surname"=> $user->getParentObj()->getSurname(),
                "name"=> $user->getParentObj()->getName(),
                "email"=> $user->getParentObj()->getEmail()
            ];
        } else {
            $data["parent"] = [
                "eid" => -1
            ];
        }

        if ($user->getParent2Obj() !== null) {
            $data["parent2"] = [
                "eid" => $user->getParent2Obj()->getParentId(),
                "surname"=> $user->getParent2Obj()->getSurname(),
                "name"=> $user->getParent2Obj()->getName(),
                "email"=> $user->getParent2Obj()->getEmail()
            ];
        } else {
            $data["parent2"] = [
                "eid" => -1
            ];
        }

        $data = array_merge($data, [
            "absence"=>$user->getAbsenceState(),
            "teachers"=>$teachers,
            "asvid"=>$user->getASVId()
        ]);
        break;
}

$api->send($data, "Current user information.");

?>
