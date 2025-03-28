<?php

namespace LasseRafn\Economic;

use LasseRafn\Economic\Builders\AccountBuilder;
use LasseRafn\Economic\Builders\AccountingEntryBuilder;
use LasseRafn\Economic\Builders\AccountingPeriodTotalsBuilder;
use LasseRafn\Economic\Builders\AccountingYearBuilder;
use LasseRafn\Economic\Builders\AdditionalInventoryDataBuilder;
use LasseRafn\Economic\Builders\ArchivedOrderBuilder;
use LasseRafn\Economic\Builders\BookedInvoiceBuilder;
use LasseRafn\Economic\Builders\Builder;
use LasseRafn\Economic\Builders\ContactBuilder;
use LasseRafn\Economic\Builders\CostTypeBuilder;
use LasseRafn\Economic\Builders\CostTypeGroupBuilder;
use LasseRafn\Economic\Builders\CustomerAddressBuilder;
use LasseRafn\Economic\Builders\CustomerBuilder;
use LasseRafn\Economic\Builders\CustomerGroupBuilder;
use LasseRafn\Economic\Builders\DeliveryLocationBuilder;
use LasseRafn\Economic\Builders\DepartmentBuilder;
use LasseRafn\Economic\Builders\DraftInvoiceBuilder;
use LasseRafn\Economic\Builders\DraftOrderBuilder;
use LasseRafn\Economic\Builders\EmployeeBuilder;
use LasseRafn\Economic\Builders\EmployeeGroupBuilder;
use LasseRafn\Economic\Builders\JournalBuilder;
use LasseRafn\Economic\Builders\JournalEntriesBuilder;
use LasseRafn\Economic\Builders\JournalVouchersBuilder;
use LasseRafn\Economic\Builders\LayoutBuilder;
use LasseRafn\Economic\Builders\PaidInvoiceBuilder;
use LasseRafn\Economic\Builders\PaymentTermBuilder;
use LasseRafn\Economic\Builders\ProductBuilder;
use LasseRafn\Economic\Builders\ProductCurrencyPriceBuilder;
use LasseRafn\Economic\Builders\ProjectBuilder;
use LasseRafn\Economic\Builders\ProjectGroupBuilder;
use LasseRafn\Economic\Builders\ResourceApi\Products\ProductGroupBuilder;
use LasseRafn\Economic\Builders\ResourceApi\Products\ProductGroupVatZoneBuilder;
use LasseRafn\Economic\Builders\ResourceApi\SupplierGroup\SupplierGroupBuilder;
use LasseRafn\Economic\Builders\ResourceApi\Customers\CustomerContactBuilder;
use LasseRafn\Economic\Builders\SelfBuilder;
use LasseRafn\Economic\Builders\SentOrderBuilder;
use LasseRafn\Economic\Builders\SupplierBuilder;
use LasseRafn\Economic\Builders\UnitBuilder;
use LasseRafn\Economic\Builders\UserBuilder;
use LasseRafn\Economic\Builders\VatZoneBuilder;
use LasseRafn\Economic\Builders\VatTypeBuilder;
use LasseRafn\Economic\Builders\VatAccountBuilder;
use LasseRafn\Economic\Builders\VoucherBuilder;
use LasseRafn\Economic\Models\CompanySelf;
use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class Economic
{
	protected $request;

	protected $newApiRequest;

	protected $agreement;

	protected $apiSecret;

	protected $apiPublic;

	protected $stripNullValues;

	public function __construct( $agreement = null, $apiSecret = null, $apiPublic = null, $stripNull = null, $base_uri = null )
	{
		$this->agreement       = $agreement ?? config( 'economic.agreement' );
		$this->apiSecret       = $apiSecret ?? config( 'economic.secret_token' );
		$this->apiPublic       = $apiPublic ?? config( 'economic.public_token' );
		$this->stripNullValues = $stripNull ?? config( 'economic.strip_null', false );

		$this->initRequest( $base_uri );
		$this->initNewApiRequest( config( 'economic.rest_endpoint' ) );
	}

	public function addBeforeRequestHook( $callback )
	{
		$this->request->beforeRequestHooks[] = $callback;
	}

	public function setAgreement( $agreement = '' )
	{
		$this->agreement = $agreement;

		$this->initRequest();

		return $this;
	}

	public function setApiSecret( $apiSecret = '' )
	{
		$this->apiSecret = $apiSecret;

		$this->initRequest();

		return $this;
	}

	public function setApiPublicToken( $apiPublic = '' )
	{
		$this->apiPublic = $apiPublic;

		return $this;
	}

	public function getApiTokenFromUrl()
	{
		return $_GET['token'] ?? null;
	}

	public function getAuthUrl( $redirectUrl = '' )
	{
		if ( $redirectUrl !== '' ) {
			$redirectUrl = '&redirectUrl=' . urlencode( $redirectUrl );
		}

		return config( 'economic.auth_endpoint' ) . $this->apiPublic . $redirectUrl;
	}

	/**
	 * @return CustomerBuilder|Builder
	 */
	public function customers()
	{
		return new CustomerBuilder( $this->request );
	}

	/**
	 * @return AccountBuilder()|Builder
	 */
	public function accounts()
	{
		return new AccountBuilder( $this->request );
	}

	/**
	 * @return DepartmentBuilder|Builder
	 */
	public function departments()
	{
		return new DepartmentBuilder( $this->request );
	}

	/**
	 * @return SupplierBuilder()|Builder
	 * @deprecated use suppliers() instead
	 *
	 */
	public function experimentalSuppliers()
	{
		return $this->suppliers();
	}

	/**
	 * @return SupplierBuilder()|Builder
	 */
	public function suppliers()
	{
		return new SupplierBuilder( $this->request );
	}

	/**
	 *
	 * @return JournalBuilder()|Builder
	 */
	public function journals()
	{
		return new JournalBuilder( $this->request );
	}

	/**
	 * @return SupplierGroupBuilder()|Builder
	 */
	public function supplierGroups()
	{
		return new SupplierGroupBuilder( $this->newApiRequest );
	}

	/**
	 * @return CustomerGroupBuilder|Builder
	 */
	public function customersGroups()
	{
		return new CustomerGroupBuilder( $this->request );
	}

	/**
	 * @return LayoutBuilder|Builder
	 */
	public function layouts()
	{
		return new LayoutBuilder( $this->request );
	}

	/**
	 * @param integer $customerNumber
	 *
	 * @return ContactBuilder()|Builder
	 */
	public function customerContacts( $customerNumber )
	{
		return new ContactBuilder( $this->request, $customerNumber );
	}

	/**
	 *
	 * @return CustomerContactBuilder()|Builder
	 */
	public function resourceCustomerContacts()
	{
		return new CustomerContactBuilder( $this->newApiRequest );
	}

	/**
	 * @param integer $customerNumber
	 *
	 * @return CustomerAddressBuilder()|Builder
	 */
	public function customerAddresses( $customerNumber )
	{
		return new CustomerAddressBuilder( $this->request, $customerNumber );
	}

	/**
	 * @return VatZoneBuilder|Builder
	 */
	public function vatZones()
	{
		return new VatZoneBuilder( $this->request );
	}
	
	/**
	 * @return VatTypeBuilder|Builder
	 */
	public function vatTypes()
	{
		return new VatTypeBuilder( $this->request );
	}
	
	/**
	 * @return VatAccountBuilder|Builder
	 */
	public function vatAccounts()
	{
		return new VatAccountBuilder( $this->request );
	}

	/**
	 * @return PaymentTermBuilder|Builder
	 */
	public function paymentTerms()
	{
		return new PaymentTermBuilder( $this->request );
	}

	/**
	 * @return DraftInvoiceBuilder|Builder
	 */
	public function draftInvoices()
	{
		return new DraftInvoiceBuilder( $this->request );
	}

	/**
	 * @return BookedInvoiceBuilder|Builder
	 */
	public function bookedInvoices()
	{
		return new BookedInvoiceBuilder( $this->request );
	}

	/**
	 * @return PaidInvoiceBuilder|Builder
	 */
	public function paidInvoices()
	{
		return new PaidInvoiceBuilder( $this->request );
	}

	/**
	 * @return ProductBuilder()|Builder
	 */
	public function products()
	{
		return new ProductBuilder( $this->request );
	}

	/**
	 * @return ProductGroupBuilder()|Builder
	 */
	public function productGroups()
	{
		return new ProductGroupBuilder( $this->newApiRequest );
	}

	/**
	 * @return ProductGroupVatZoneBuilder()|Builder
	 */
	public function productGroupVatZones(int $productGroup)
	{
		return new ProductGroupVatZoneBuilder( $this->newApiRequest, $productGroup );
	}

	/**
	 * @return ProductCurrencyPriceBuilder()|Builder
	 */
	public function productCurrencyPrices( $productNumber )
	{
		return new ProductCurrencyPriceBuilder( $this->request, $productNumber );
	}

	/**
	 * @return UnitBuilder()|Builder
	 */
	public function units()
	{
		return new UnitBuilder( $this->request );
	}

	/**
	 * @return EmployeeBuilder()|Builder
	 */
	public function employees()
	{
		return new EmployeeBuilder( $this->newApiRequest );
	}

	/**
	 * @return EmployeeGroupBuilder()|Builder
	 */
	public function employeeGroups()
	{
		return new EmployeeGroupBuilder( $this->newApiRequest );
	}

	/**
	 * @return ProjectBuilder()|Builder
	 */
	public function projects()
	{
		return new ProjectBuilder( $this->newApiRequest );
	}

	/**
	 * @return ProjectGroupBuilder()|Builder
	 */
	public function projectsGroups()
	{
		return new ProjectGroupBuilder( $this->newApiRequest );
	}

	/*
	   * @return CostTypeBuilder|Builder
	   */
	public function cost_types()
	{
		return new CostTypeBuilder( $this->newApiRequest );
	}

	/**
	 * @return CostTypeGroupBuilder()|Builder
	 */
	public function cost_type_groups()
	{
		return new CostTypeGroupBuilder( $this->newApiRequest );
	}

	/**
	 * @return UserBuilder()|Builder
	 *
	 * WARNING: Undocumented endpoint!
	 */
	public function users()
	{
		return new UserBuilder( $this->request );
	}

	/**
	 * @return \LasseRafn\Economic\Builders\ArchivedOrderBuilder
	 */
	public function archivedOrders()
	{
		return new ArchivedOrderBuilder( $this->request );
	}

	/**
	 * @return CompanySelf|Model
	 */
	public function self()
	{
		return ( new SelfBuilder( $this->request ) )->find( '' );
	}

	/**
	 * @return \LasseRafn\Economic\Builders\SentOrderBuilder
	 */
	public function sentOrders()
	{
		return new SentOrderBuilder( $this->request );
	}

	/**
	 * @return DraftOrderBuilder
	 */
	public function draftOrders()
	{
		return new DraftOrderBuilder( $this->request );
	}

	/**
	 * @return AdditionalInventoryDataBuilder
	 */
	public function additionalInventoryData()
	{
		return new AdditionalInventoryDataBuilder( $this->request );
	}

	/**
	 * @param int|null $year
	 *
	 * @return AccountingYearBuilder()|Builder
	 */
	public function accountingYear( int $account, $year = null )
	{
		if ( $year === null ) {
			$year = (int) date( 'Y' );
		}

		return new AccountingYearBuilder( $this->request, $account, $year );
	}

	/**
	 *
	 * @return AccountingPeriodTotalsBuilder()|Builder
	 */
	public function accountingPeriodTotal( $account, $year, $period )
	{
		return new AccountingPeriodTotalsBuilder( $this->request, $account, $year, $period );
	}

	/**
	 *
	 * @return AccountingEntryBuilder()|Builder
	 */
	public function accountingEntries( $account, $year, $period )
	{
		return new AccountingEntryBuilder( $this->request, $account, $year, $period );
	}

	/**
	 * @param int|null $year
	 *
	 * @return VoucherBuilder()|Builder
	 */
	public function accountingYearVouchers( $year = null )
	{
		if ( $year === null ) {
			$year = (int) date( 'Y' );
		}

		return new VoucherBuilder( $this->request, $year );
	}


	public function getOrderLines( int $orderNumber, Model $entity ): ?array
	{
		$order = null;
		$lines = null;

		if ( str_contains( get_class( $entity ), 'SentOrder' ) ) {
			$order = $this->sentOrders()->find( $orderNumber );
		} else if ( str_contains( get_class( $entity ), 'DraftOrder' ) ) {
			$order = $this->draftOrders()->find( $orderNumber );
		} else if ( str_contains( get_class( $entity ), 'ArchivedOrder' ) ) {
			$order = $this->archivedOrders()->find( $orderNumber );
		}

		if ( ! is_null( $order ) ) {
			$lines = $order->lines;
		}
		if ( ! \is_array( $lines ) ) {
			$lines = [ $lines ];
		}

		return $lines;
	}

	public function downloadInvoice( $directUrl )
	{
		return $this->request->doRequest( 'get', $directUrl )->getBody()->getContents();
	}

	protected function initRequest( $baseUri = null )
	{
		$this->request = new Request( $this->agreement, $this->apiSecret, $this->stripNullValues, $baseUri );
	}

	protected function initNewApiRequest( $baseUri = null )
	{
		$this->newApiRequest = new Request( $this->agreement, $this->apiSecret, $this->stripNullValues, $baseUri );
	}


	/**
	 * @return JournalVouchersBuilder
	 */
	public function journalVouchers( $journalNumber )
	{
		return new JournalVouchersBuilder( $this->request, $journalNumber );
	}

	/**
	 * @return JournalEntriesBuilder
	 */
	public function journalEntries( $journalNumber )
	{
		return new JournalEntriesBuilder( $this->request, $journalNumber );
	}

	/**
	 * @return DeliveryLocationBuilder
	 */
	public function deliveryLocations()
	{
		return new DeliveryLocationBuilder( $this->newApiRequest );
	}
}
