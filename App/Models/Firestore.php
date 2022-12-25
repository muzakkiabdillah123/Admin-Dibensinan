<?php

namespace App\Models;

use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\CollectionReference;

class Firestore
{
    private $firestore;
    private $collectionName;
    private $documentName;

    public function __construct()
    {
        $this->firestore = new FirestoreClient([
            "keyFilePath" => "Keys/coba-project-a5119-6c69d8d47973.json",
            "projectId" => "coba-project-a5119",
        ]);
    }

    // collection name setter
    public function setCollectionName(string $name): Firestore
    {
        $this->collectionName = $name;
        return $this;
    }

    // document name settings
    public function setDocumentName(string $name): Firestore
    {
        !empty($this->collectionName) || die("Please provide document name");
        $this->documentName = $name;
        return $this;
    }

    // get document from the collection
    public function getDocument(): DocumentReference
    {
        !empty($this->documentName) || die("Please provide document name");

        $collection = $this->firestore->collection($this->collectionName);

        if (!$collection->documents()->isEmpty()) {
            return $collection->document($this->documentName);
        }
        return null;
    }

    // get all data or some key
    public function getData(string $key = "")
    {
        if (!empty($key)) {
            return $this->getDocument()->snapshot()->get($key);
        } else {
            return $this->getDocument()->snapshot()->data();
        }
    }

    // add new document to the collection
    public function newDocument(array $data): string
    {
        !empty($this->collectionName) || die("Please provide collection name");
        return $this->firestore->collection($this->collectionName)->add($data)->id();
    }

    public function deleteDocument(string $name): array
    {
        !empty($this->collectionName) || die("Please provide collection name");
        return $this->firestore->collection($this->collectionName)->document($name)->delete();
    }

    public function updateDocument(string $key, $value): array
    {
        !empty($this->collectionName) || die("Please provide collection name");
        return $this->firestore->collection($this->collectionName)->document($this->documentName)->update([
            [
                "path" => $key,
                "value" => $value,
            ],
        ], [
            "merge" => true,
        ]);
    }

    //count all document in the collection
    public function countDocument(): int
    {
        !empty($this->collectionName) || die("Please provide collection name");
        return $this->firestore->collection($this->collectionName)->documents()->size();
    }

    // print all document in the collection
    public function checkLogin(string $input = "", string $key = ""): void
    {
        $list = [];
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                $document->data()[$key];
                // store all data in the list
                array_push($list, $document->data()[$key]);
            }
        }
        // check if input is in the list
        if (in_array($input, $list)) {
            $_SESSION["login"] = true;
            header("Location: index.php");
            exit;
        } else {
            echo '<script>alert("username atau password salah")</script>';
        }
    }

    public function checkLoginMitra(string $input = "", string $key = ""): void
    {
        $list = [];
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                $document->data()[$key];
                // store all data in the list
                array_push($list, $document->data()[$key]);
            }
        }
        // check if input is in the list
        if (in_array($input, $list)) {
            $_SESSION["login_mitra"] = true;
            header("Location: index_mitra.php");
            exit;
        } else {
            echo '<script>alert("username atau password salah")</script>';
        }
    }

    // get document id from key
    public function getDocumentId(string $key, string $value): string
    {
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                if ($document->data()[$key] == $value) {
                    return $document->id();
                }
            }
        }
        return null;
    }

    // get all document in the collection
    public function getAllDocument(): array
    {
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        $list = [];
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                array_push($list, $document->data());
            }
        }
        return $list;
    }

    //get all document id in the collection
    public function getAllDocumentId(): array
    {
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        $list = [];
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                array_push($list, $document->id());
            }
        }
        return $list;
    }

    // count how many document who have the same value
    public function countDocumentFromKey(string $key, string $value): int
    {
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        $count = 0;
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                if ($document->data()[$key] == $value) {
                    $count++;
                }
            }
        }
        return $count;
    }

    // get all document who have the same value
    public function getDocumentFromKey(string $key, string $value): array
    {
        !empty($this->collectionName) || die("Please provide collection name");
        $collection = $this->firestore->collection($this->collectionName);
        $list = [];
        if (!$collection->documents()->isEmpty()) {
            foreach ($collection->documents() as $document) {
                if ($document->data()[$key] == $value) {
                    array_push($list, $document->data());
                }
            }
        }
        return $list;
    }
}
