<?php

/*
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace namespace Manager\DAO\DataModel;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;

/**
 * Class Datastore implements the DataModel with a Google Data Store.
 */
class Datastore implements DataModelInterface
{
    private $datasetId;
    private $datastore;
    protected $columns = [
        'id'            => 'integer',
        'emotion'         => 'string',
        'content'        => 'string',
        'publishedDate' => 'timestamp',
    ];

    public function __construct($projectId)
    {
        $this->datasetId = $projectId;
        $this->datastore = new DatastoreClient([
            'projectId' => $projectId,
        ]);
    }

    public function findAll($cursor = null,$limit = 5)
    {
        $query = $this->datastore->query()
            ->kind('Emotions')
            ->order('publishedDate')
            ->limit($limit)
            ->start($cursor*$limit));

        $results = $this->datastore->runQuery($query);

        $emos = [];
        $nextPageCursor = null;
        foreach ($results as $entity) 
        {
            $emo = $entity->get();
            $emo['id'] = $entity->key()->pathEndIdentifier();
            $emos[] = arrayToEmotion($emo);
            $nextPageCursor = $entity->cursor();
        }

        return [
            'emos' => $emos,
            'cursor' => $nextPageCursor,
        ];
    }
    /**
    *Save emotion
    */
    public function save($emo)
    {
        $emo->setPublishDate(new DateTime());
        $key = $this->datastore->key('Feelings');
        $entity = $this->datastore->entity($key, $emo->getArray());

        $this->datastore->insert($entity);

        return $entity->key()->pathEndIdentifier();
    }
    /**
    * Read emotions name from id
    */
    public function readEmotion($name)
    {
        $key = $this->datastore->key('Emotions', $name);
        $entity = $this->datastore->lookup($key);

        if ($entity) {
            $emo = $entity->get();
        
            return emo['nom'];
        }

        return false;
    }
    private function arrayToEmotion($emo)
    {
            $emo = new Emotion();
            $emo->setId($emo['id']);
            $emo->setEmotionContent($emo['emotion']);
            $emo->setContent($emo['content']);
            $emo->setPublishDate($emo['publishedDate']);
            return $emo;
    }
/* not implémented yet
    public function update($emo)
    {
        $this->verifyBook($emo);

        if (!isset($emo['id'])) {
            throw new \InvalidArgumentException('Emotions must have an "id" attribute');
        }

        $transaction = $this->datastore->transaction();
        $key = $this->datastore->key('Emotions', $emo['id']);
        $task = $transaction->lookup($key);
        unset($emo['id']);
        $entity = $this->datastore->entity($key, $book);
        $transaction->upsert($entity);
        $transaction->commit();

        // return the number of updated rows
        return 1;
    }

    public function delete($id)
    {
        $key = $this->datastore->key('Emotions', $id);
        return $this->datastore->delete($key);
    }

    private function verifyBook($emo)
    {
        if ($invalid = array_diff_key($emo, $this->columns)) {
            throw new \InvalidArgumentException(sprintf(
                'unsupported emo properties: "%s"',
                implode(', ', $invalid)
            ));
        }
    }*/
}