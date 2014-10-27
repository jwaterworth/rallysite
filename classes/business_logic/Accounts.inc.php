<?php
require_once(BUSLOGIC_PATH."/BusinessLogic.inc.php");

/**
 * Description of Accounts
 *
 * @author James
 */
class Accounts extends BusinessLogic {
    
    public function GetAccount($id) {
        $dbAccounts = AccountFactory::GetDataAccessObject();
        
        $account = $dbAccounts->GetById($id);
        
        if($account == null) {
            throw new Exception("Account does not exist");
        }
        
        return $account;
    }
    
    public function GetAccountByUsername($username) {
        $dbAccounts = AccountFactory::GetDataAccessObject();
        
        $accounts = $dbAccounts->GetByAttribute(AccountVO::$dbEmail, $username);
        
        //Initialise account
        $account = null;
        
        //Should only be one account, but function returns an array rather
        //than an object
        foreach($accounts as $accountVO) {
            $account = $accountVO;
            break;
        }
        
        if($account == null) {
            throw new Exception("Account does not exist");
        }
        
        return $account;
    }
	
	public function GetAccountsByEmail($email) {
		$dbAccounts = AccountFactory::GetDataAccessObject();
        
        $accounts = $dbAccounts->GetByAttribute(AccountVO::$dbEmail, $email);
        
        return $accounts;
	}
    
    public function GetClubAccounts(ClubVO $club) {
        $accounts = array();
        $dbAccounts = AccountFactory::GetDataAccessObject();
        
        $accounts = $dbAccounts->GetByAttribute(AccountVO::$dbClubID, $club->getId());
        
        //Exception not required as clubs may not necessarily have members
        
        return $accounts;
    }
    
    public function ChangeAccountLevel(AccountVO $account, $accountTypeID = MEMBER) {
        $dbAccounts = AccountFactory::GetDataAccessObject();
        
        //Set with new account type
        $account->setAccountTypeID($accountTypeID);
        
        //Save and confirm change
        if($dbAccounts->Save($account) < 1) {
            throw new Exception("An error occured changing user permissions");
        }
        
        return true;
    }
    
    public function GetMemberClub(AccountVO $account) {
        $dbClubs = ClubFactory::GetDataAccessObject();
        $club = $dbClubs->GetById($account->getClubID());
        
        if($club == null) {
            throw new Exception("Club not found for member: " . $account->getName());
        }
        
        return $club;
    }
    
    public function GetMemberType(AccountVO $account) {
        $dbAccountTypes = AccountTypeFactory::GetDataAccessObject();
        $accountType = $dbAccountTypes->GetById($account->getAccountTypeID());
        
        if($accountType == null) {
            throw new Exception("Account type not found for member:" . $account->getName());
        }
        
        return $accountType;
    }
    
    public function GetAllClubs() {
        $dbClubs = ClubFactory::GetDataAccessObject();
        
        $clubs = $dbClubs->GetAll("name", true);
        
        if(sizeof($clubs) < 1) {
            throw new Exception("No clubs found");
        }
        
        return $clubs;
    }
    
    public function GetClub($id) {
        $dbClubs = ClubFactory::GetDataAccessObject();
        
        $club = $dbClubs->GetById($id);
        
        if($club == null) {
            throw new Exception("Club does not exist");
        }
        
        return $club;
    }
    
    public function GetClubReps($club) {
        $clubAccounts = $this->GetClubAccounts($club);
        
        $arrClubReps = array();
        
        foreach($clubAccounts as $account) {
            if($this->GetMemberType($account)->getId() & CLUBREP) {
                $arrClubReps[] = $account;
            }
        }
        
        if(sizeof($arrClubReps) < 1 ) {
            throw new Exception("Club has no representatives");
        }
        
        return $arrClubReps;
    }
    
    public function SaveAccount(AccountVO $account) {
        $dbAccounts = AccountFactory::GetDataAccessObject();
        
        $result = $dbAccounts->Save($account);
        
        if($result < 1) {
            throw new Exception("An error occured saving account for " . $account->getName());
        }
        
        return $result;
    }
}

?>
