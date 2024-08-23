<?php

namespace LasseRafn\Economic\Builders;

use Illuminate\Support\Facades\Http;

class BillingItemBuilder extends RackbeatEndpointBuilder
{

    public function getBillingItems()
    {
        return $this->sendGetRequest( 'get-all-billing-items?token=' . $this->economicRackbeatApiToken );
    }

    public function getBillingItem( int $billingItemId )
    {
        return $this->sendGetRequest( 'get-billing-item?token=' . $this->economicRackbeatApiToken . '&id=' . $billingItemId );
    }

    public function createBillingItem( string $jsonEncodedData, array $data )
    {
        return $this->sendPostRequest(
            'create-billing-item?token=' . $this->economicRackbeatApiToken,
            $jsonEncodedData,
            $data
        );
    }

    public function deregisterBillingItem( int $billingItemId, $deregisterDate, $jsonEncodedData, $data)
    {
        return $this->sendPostRequest(
            'deregister-billing-item?token=' . $this->economicRackbeatApiToken . '&id=' . $billingItemId . '&deregisterDate=' . $deregisterDate,
            $jsonEncodedData,
            $data
        );
    }

    public function upgradeRackbeatPlan($upgradeDate, string $jsonEncodedData, array $data)
    {
        return $this->sendPostRequest(
            'upgrade-rackbeat-plan?token=' . $this->economicRackbeatApiToken . '&upgradeDate=' . $upgradeDate,
            $jsonEncodedData,
            $data
        );
    }


}