<?php
include_once(INTERFACE_PATH."/IValueObject.interface.php");

/**
 * Description of BookingInfoVO
 *
 * @author James
 */
class BookingInfoVO implements IValueObject{
    
    private $id;
    
    private $bookingSummary;
    
    private $bookingInfo;
    
    private $paymentAddress;
    
    private $paymentMemberID;
    
    public static $dbId = 'id';
    
    public static $dbBookingSummary = 'bookingSummary';
    
    public static $dbBookingInfo = 'bookingInfo';
    
    public static $dbPaymentAddress = 'paymentAddress';
    
    public static $dbPaymentMemberID = 'paymentMemberID';
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setBookingSummary($bookingSummary) {
        $this->bookingSummary = $bookingSummary;
    }

    public function setBookingInfo($bookingInfo) {
        $this->bookingInfo = $bookingInfo;
    }
    
    public function setPaymentAddress($paymentAddress) {
        $this->paymentAddress = $paymentAddress;
    }
    
    public function setPaymentMemberID($paymentMemberID) {
        $this->paymentMemberID = $paymentMemberID;
    }

    public function getId() {
        return $this->id;
    }

    public function getBookingSummary() {
        return $this->bookingSummary;
    }

    public function getBookingInfo() {
        return $this->bookingInfo;
    }
    
    public function getPaymentAddress() {
        return $this->paymentAddress;
    }
    
    public function getPaymentMemberID() {
        return $this->paymentMemberID;
    }

    
}

?>
