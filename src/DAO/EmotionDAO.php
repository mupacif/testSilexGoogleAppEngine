<?php

namespace Manager\DAO;

use Doctrine\DBAL\Connection;
use Manager\Model\Emotion;

class EmotionDAO
{
	private $db;

	public function __construct(Connection $db)
	{
		$this->db = $db;
	}

	 public function findAll($index='0') {
        $sql = "select emotions.id as id, emo_names.name as emotion,emotions.content from emotions join emo_names on emotions.emotion=emo_names.id LIMIT ".($index*5).", 5";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $emos = array();
        foreach ($result as $row) {
            $emoId = $row['id'];
            $emos[$emoId] = $this->buildEmotion($row);
        }
        return $emos;
    }

        private function buildEmotion(array $row)
        {
        $emo = new Emotion();
        $emo->setId($row['id']);
        $emo->setEmotion($row['emotion']);
        $emo->setContent($row['content']);
        return $emo;
    	}

    	public function save(Emotion $emo)
    	{
    		 $sql = "insert emotions(emotion,content) value (?,?)";
       		 $result = $this->db->executeQuery($sql,array($emo->getEmotion(),
       		 	$emo->getContent()));
        
    	}

}