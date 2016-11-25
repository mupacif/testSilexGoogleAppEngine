<?php 
namespace Manager\Model;

class Emotion
{
	/**
	*Emotion id
	*
	*@var integer
	*/
	private $id;
	/**
	*Emotion emotion
	*
	*@var string
	*/
	private $emotion;
	/**
	* Emotion content
	*@var string
	*/
	private $content;
	/**
	* Emotion date creation
	*@var timestamp
	*/
	private publishedDate;


	public function getId()
	{
	 	return $this->id;
	}

	public function setId($id)
	{
	 	return $this->id=$id;
	}
	public function getEmotion()
	{
		return $this->emotion;
	}
		public function setEmotion($content)
	{
		return $this->emotion=$content;
	}

	public function getContent()
	{
		return $this->content;
	}
		public function setContent($content)
	{
		return $this->content=$content;
	}

	public function getArray()
	{
		return array(
			"id"=>$this->id,
			"emotion"=>"Key('Emotions','".$this->emotion."')";,
			"content"=>$this->content,
			"publishedDate"=>$this->publishedDate
			);
	}

	public function getPublishedDate()
	{
	 	return $this->publishedDate;
	}

	public function setPublishedDate($timestamp)
	{
	 	return $this->publishedDate=$timestamp;
	}
}