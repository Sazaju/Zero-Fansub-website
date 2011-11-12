<?php
/*
	A codec is used by a release. There is several kind of codecs regarding the needs.
*/
abstract class Codec {
	public abstract function getID();
	public abstract function getName();
	
	public static $allCodecs = null;
	public static function getAllCodecs() {
		if (Codec::$allCodecs === null) {
			Codec::$allCodecs = array();
			Codec::$allCodecs[] = new VideoCodec("xvid", "XviD");
			Codec::$allCodecs[] = new VideoCodec("h264", "H264");
			Codec::$allCodecs[] = new SoundCodec("mp3", "MP3");
			Codec::$allCodecs[] = new SoundCodec("aac", "AAC");
			Codec::$allCodecs[] = new SoundCodec("ac3", "AC3");
			Codec::$allCodecs[] = new ContainerCodec("mp4", "MP4");
			Codec::$allCodecs[] = new ContainerCodec("mkv", "MKV");
			Codec::$allCodecs[] = new ContainerCodec("avi", "AVI");
		}
		return Codec::$allCodecs;
	}
	
	public static function getCodec($id) {
		foreach(Codec::getAllCodecs() as $codec) {
			if ($codec->getID() === $id) {
				return $codec;
			}
		}
		throw new Exception($id." is not a known codec ID.");
	}
}
class AbstractCodec extends Codec {
	private $id = null;
	private $name = null;
	
	public function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public function getID() {
		return $this->id;
	}
	public function getName() {
		return $this->name;
	}
}
class VideoCodec extends AbstractCodec {}
class SoundCodec extends AbstractCodec {}
class ContainerCodec extends AbstractCodec {}
?>
