<?php

require __DIR__ . "/Base.php";
require __DIR__ . "/../model/Niconico.php";
require __DIR__ . "/../model/Auth.php";

class NiconicoController extends Base
{
  function GetVideoIdList()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["accessToken"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'accessToken' is not set."
      ];
    } else if (!isset($this->body["url"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'url' is not set."
      ];
    }

    // define
    $auth = new Auth();
    $niconico = new Niconico();
    $access_token = $this->body["accessToken"];
    $url = $this->body["url"];

    // check AccessToken
    $result = $auth->CheckAccessToken($access_token);

    if ($result["status"] !== "success") {
      return $result;
    }

    // get VideoID List
    $result = $niconico->GetVideoIdList($url);

    return $result;
  }


  function GetOfficialInfo()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["accessToken"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'accessToken' is not set."
      ];
    } else if (!isset($this->body["videoId"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'videoId' is not set."
      ];
    }

    // define
    $auth = new Auth();
    $niconico = new Niconico();
    $access_token = $this->body["accessToken"];
    $video_id = $this->body["videoId"];

    // check AccessToken
    $result = $auth->CheckAccessToken($access_token);

    if ($result["status"] !== "success") {
      return $result;
    }

    // get official info
    $result = $niconico->GetOfficialInfo($video_id);

    return $result;
  }


  function ReadVideoList()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["accessToken"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'accessToken' is not set."
      ];
    } else if (!isset($this->body["mode"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'mode' is not set."
      ];
    }

    // define
    $auth = new Auth();
    $niconico = new Niconico();
    $access_token = $this->body["accessToken"];
    $mode = $this->body["mode"];

    // check AccessToken
    $result = $auth->CheckAccessToken($access_token);

    if ($result["status"] !== "success") {
      return $result;
    }

    // read Video List
    $result = $niconico->ReadVideoList($mode);

    return $result;
  }


  function InsertVideo()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["accessToken"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'accessToken' is not set."
      ];
    } else if (!isset($this->body["videoId"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'videoId' is not set."
      ];
    } else if (!isset($this->body["title"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'title' is not set."
      ];
    } else if (!isset($this->body["favorite"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'favorite' is not set."
      ];
    } else if (!isset($this->body["skip"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'skip' is not set."
      ];
    }

    // define
    $auth = new Auth();
    $niconico = new Niconico();
    $access_token = $this->body["accessToken"];
    $video_id = $this->body["videoId"];
    $title = $this->body["title"];
    $favorite = $this->body["favorite"];
    $skip = $this->body["skip"];

    // check AccessToken
    $result = $auth->CheckAccessToken($access_token);

    if ($result["status"] !== "success") {
      return $result;
    }

    // insert video
    $result = $niconico->InsertVideo($video_id, $title, $favorite, $skip);

    return $result;
  }


  function UpdateVideo()
  {
    // validate version
    if (!in_array($this->version, ["v1"])) {
      return [
        "status" => "failure",
        "message" => "Version $this->version is not accepted."
      ];
    }

    // validate body
    if (!isset($this->body["accessToken"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'accessToken' is not set."
      ];
    } else if (!isset($this->body["id"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'id' is not set."
      ];
    } else if (!isset($this->body["videoId"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'videoId' is not set."
      ];
    } else if (!isset($this->body["title"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'title' is not set."
      ];
    } else if (!isset($this->body["favorite"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'favorite' is not set."
      ];
    } else if (!isset($this->body["skip"])) {
      return [
        "status" => "failure",
        "message" => "Parameter 'skip' is not set."
      ];
    }

    // define
    $auth = new Auth();
    $niconico = new Niconico();
    $access_token = $this->body["accessToken"];
    $id = $this->body["id"];
    $video_id = $this->body["videoId"];
    $title = $this->body["title"];
    $favorite = $this->body["favorite"];
    $skip = $this->body["skip"];

    // check AccessToken
    $result = $auth->CheckAccessToken($access_token);

    if ($result["status"] !== "success") {
      return $result;
    }

    // update video
    $result = $niconico->UpdateVideo($id, $video_id, $title, $favorite, $skip);

    return $result;
  }
}
