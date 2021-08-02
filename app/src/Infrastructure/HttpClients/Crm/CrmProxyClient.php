<?php

namespace App\Infrastructure\HttpClients\Crm;

use SoapClient;
use App\Infrastructure\HttpClients\Crm\CrmProxyClientInterface;

/**
 * Class CrmProxyClient.
 */
class CrmProxyClient implements CrmProxyClientInterface
{
    /**
     * @var SoapClient
     */
    private SoapClient $soapClient;

    /**
     * CrmProxyClient constructor.
     *
     * @param string $wsdlUrl
     * @param string $defaultRequestTimeout
     *
     * @throws \SoapFault
     */
    public function __construct(string $wsdlUrl, string $defaultRequestTimeout)
    {
        $this->soapClient = new SoapClient($wsdlUrl, ['connection_timeout' => $defaultRequestTimeout]);
    }

    /**
     * @inheritdoc
     */
    public function getJobTitlesWithProducts(): array
    {
        return $this->soapClient->__soapCall('GetJobtitlesWithProducts', [])
                ->GetJobtitlesWithProductsResult
                ->JobtitleWithProductsData;
    }
}
