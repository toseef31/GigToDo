<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_TagManager_UpdateWorkspaceSidelineRequest extends Google_Collection
{
  protected $collection_key = 'reviewers';
  public $fingerprint;
  protected $newCommentType = 'Google_Service_TagManager_WorkspaceSidelineHistoryComment';
  protected $newCommentDataType = '';
  protected $reviewersType = 'Google_Service_TagManager_WorkspaceSidelineUser';
  protected $reviewersDataType = 'array';
  public $status;

  public function setFingerprint($fingerprint)
  {
    $this->fingerprint = $fingerprint;
  }
  public function getFingerprint()
  {
    return $this->fingerprint;
  }
  /**
   * @param Google_Service_TagManager_WorkspaceSidelineHistoryComment
   */
  public function setNewComment(Google_Service_TagManager_WorkspaceSidelineHistoryComment $newComment)
  {
    $this->newComment = $newComment;
  }
  /**
   * @return Google_Service_TagManager_WorkspaceSidelineHistoryComment
   */
  public function getNewComment()
  {
    return $this->newComment;
  }
  /**
   * @param Google_Service_TagManager_WorkspaceSidelineUser
   */
  public function setReviewers($reviewers)
  {
    $this->reviewers = $reviewers;
  }
  /**
   * @return Google_Service_TagManager_WorkspaceSidelineUser
   */
  public function getReviewers()
  {
    return $this->reviewers;
  }
  public function setStatus($status)
  {
    $this->status = $status;
  }
  public function getStatus()
  {
    return $this->status;
  }
}
