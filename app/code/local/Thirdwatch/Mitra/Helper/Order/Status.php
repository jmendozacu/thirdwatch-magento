<?php
/**
 *  this class is being used to initiate the statuses in magento config database.
*/
class Thirdwatch_Mitra_Helper_Order_Status extends Mage_Core_Helper_Abstract
{

    public function getOnHoldStatusCode()
    {
        return 'thirdwatch_holded';
    }

    public function getOnHoldStatusLabel()
    {
        return 'Hold (Thirdwatch)';
    }

    public function getThirdwatchDeclinedStatusCode()
    {
        return 'thirdwatch_declined';
    }

    public function getThirdwatchDeclinedStatusLabel()
    {
        return 'Declined (Thirdwatch)';
    }

    public function getThirdwatchApprovedStatusCode()
    {
        return 'thirdwatch_approved';
    }

    public function getThirdwatchApprovedStatusLabel()
    {
        return 'Approved (Thirdwatch)';
    }

    public function getThirdwatchFlaggedStatusCode()
    {
        return 'thirdwatch_flagged';
    }

    public function getThirdwatchFlaggedStatusLabel()
    {
        return 'Flagged (Thirdwatch)';
    }

}