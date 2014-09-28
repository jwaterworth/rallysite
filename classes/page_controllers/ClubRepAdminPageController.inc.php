<?php
require_once(PAGE_CONTROLLERS."/PageController.inc.php");

/**
 * Description of ClubRepAdminController
 *
 * @author Bernard
 */
class ClubRepAdminPageController extends PageController {
    
    function __construct() {
        $this->data = array();
    }
    
    function GetClubData() {
        
        if(!$this->CheckAuth(CLUBREP, false)) {
            $this->errorMessage = "You must be a club representative to access this area.";
            return;
        }
        
        $accountData = LogicFactory::CreateObject("Accounts");
        $clubMembers = null;
		
		$this->data['unapproved'] = array();
		$this->data['approved'] = array();
        
        //Get club
        try {
            $userID = Authentication::GetLoggedInId();
            $clubRepAccount = $accountData->GetAccount($userID);
            $club = $accountData->GetMemberClub($clubRepAccount);
            $this->data['club'] = $club->getName();
            $clubMembers = $accountData->GetClubAccounts($club);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
        
        //Split club members into approved and non approved
        $arrNonApproved = 
        $arrApproved = array();
        
        foreach($clubMembers as $accountVO) {
            try { 
                $accountType = $accountData->GetMemberType($accountVO);
                //If account type ID does not match any known account type then put on non approved list
                if($accountType->getId() & APPROVED) { 
                    $this->data['approved'][] = $this->SetAccountData($accountVO, $accountData);
                } else {
                    $this->data['unapproved'][] = $this->SetAccountData($accountVO, $accountData);
                }
            } catch (Exception $e) {
                $this->errorMessage = ": Error processing " . $accountVO->getName() . "'s account ";
            }            
        }
    }
    
    public function ApproveClubMember($accountId) {
        //Confirm club rep
        if(!$this->CheckAuth(CLUBREP, false)) {
            $this->errorMessage = "Oh no you don't, non club rep!";
            return;
        }
        
        $accountData = LogicFactory::CreateObject("Accounts");
        $accountData = new Accounts();
        try {
            //Check club account and user account match
			$currUserId = Authentication::GetLoggedInId();
            $clubAccount = $accountData->GetAccount($currUserId);
			
            $account = $accountData->GetAccount($accountId);
			
            if($accountData->GetMemberClub($account)->getId() == $accountData->GetMemberClub($clubAccount)->getId()) {
                $accountData->ChangeAccountLevel($account, MEMBER);
                //Send approval mail
                $emailer = new Email();
                $emailer->SendAccountApprovalEmail($account);
            } else {
                $this->errorMessage = "Club representative and member's club do not match";
                return;
            }
            
        } catch(Exception $e) {
            $this->errorMessage = $e->getMessage();
            return;
        }
        
        return true;
    }

    private function SetAccountData(AccountVO $accountVO, $accountData) {
        $account = array();

        $account['id'] = $accountVO->getId();
        $account['name'] = $accountVO->getName();
        $account['email'] = $accountVO->getEmail();
        $account['phone'] = $accountVO->getPhoneNumber();
        try {
            $accountType = $accountData->GetMemberType($accountVO);
            $account['accountType'] = $accountType->getAccountTypeName();
        } catch (Exception $e) {
            $account['accountType'] = $e->getMessage();
        }
        
        return $account;
    }
}

?>
