<?php

namespace InfusionWeb\Laravel\Marketo;

use CSD\Marketo\Client as CsdMarketoClient;

class MarketoClient
{
    protected $client;

    public function __construct()
    {
        $this->client = CsdMarketoClient::factory([
            'client_id' => config('marketo.auth.client_id'),
            'client_secret' => config('marketo.auth.client_secret'),
            'munchkin_id' => config('marketo.auth.munchkin_id')
        ]);
    }

    /**
     * Prune any fields not valid for Marketo insertion.
     *
     * @param $fields
     *   Array of fields to prune, indexed by field name.
     * @return
     *   Pruned array of fields.
     */
    public function pruneFields($fields) {
        $valid = [];

        foreach ($fields as $key => $field) {
            if (in_array($key, config('marketo.fields.valid'))) {
                // Check for ignored fields.
                if (in_array($key, config('marketo.fields.ignore')) && empty($field)) {
                    // Don't pass.
                    continue;
                }

                // Serialize answers as comma-separated values for storage.
                if (is_array($field)) {
                    $values = [];

                    foreach ($field as $option) {
                        // Don't include unchecked options.
                        if (!empty($option)) {
                            $values[] = $option;
                        }
                    }
                    $field = implode(',', $values);
                }

                // Ensure that key matches REST (vs. SOAP) format.
                $valid[lcfirst($key)] = $field;
            }
        }

        return $valid;
    }

    /**
     * Get lead by ID.
     *
     * @param  int  $id  Marketo lead ID
     * @param  array  $fields  Optional names of fields to return, otherwise default set is used.
     * @return \CSD\Marketo\Response\GetLeadResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoGetLeadFailed
     * @link http://developers.marketo.com/documentation/rest/get-lead-by-id/
     */
    public function getLead($id, $fields = null)
    {
        if ($fields === null) {
            $fields = config('marketo.fields.valid');
        }

        $response = $this->client->getLead($id, $fields);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoGetLeadFailed($message, $code);
        }

        return $response->getLead();
    }

    /**
     * Get lead by cookie value.
     *
     * @param  string $cookie Marketo cookie value.
     * @param  array  $fields Optional names of fields to return, otherwise default set is used.
     * @return \CSD\Marketo\Response\GetLeadResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoGetLeadFailed
     * @link http://developers.marketo.com/documentation/rest/get-multiple-leads-by-filter-type/
     */
    public function getLeadByCookie($cookie, $fields = null)
    {
        if ($fields === null) {
            $fields = config('marketo.fields.valid');
        }

        $response = $this->client->getLeadByFilterType('cookie', $cookie, $fields);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoGetLeadFailed($message, $code);
        }

        return $response->getLead();
    }

    /**
     * Get lead by email address.
     *
     * @param  string $email  Email address.
     * @param  array  $fields Optional names of fields to return, otherwise default set is used.
     * @return \CSD\Marketo\Response\GetLeadResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoGetLeadFailed
     * @link http://developers.marketo.com/documentation/rest/get-multiple-leads-by-filter-type/
     */
    public function getLeadByEmail($email, $fields = null)
    {
        if ($fields === null) {
            $fields = config('marketo.fields.valid');
        }

        $response = $this->client->getLeadByFilterType('email', $email, $fields);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoGetLeadFailed($message, $code);
        }

        return $response->getLead();
    }

    /**
     * Delete lead by ID.
     *
     * @param  int  $lead  Marketo lead IDs
     * @return \CSD\Marketo\Response\DeleteLeadResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoDeleteLeadFailed
     * @link http://developers.marketo.com/documentation/rest/delete-lead/
     */
    public function deleteLead($lead)
    {
        $response = $this->client->deleteLead($lead);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoDeleteLeadFailed($message, $code);
        }

        return $response->getResult();
    }

    /**
     * Associate lead with cookie value.
     *
     * @param  int  $id  Marketo lead ID
     * @param  string  $cookie  Cookie value of lead
     * @return \CSD\Marketo\Response\AssociateLeadResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoAssociateLeadFailed
     * @link http://developers.marketo.com/documentation/rest/associate-lead/
     */
    public function associateLead($id, $cookie)
    {
        $response = $this->client->associateLead($id, $cookie);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoAssociateLeadFailed($message, $code);
        }

        return $response->getResult();
    }

    /**
     * Create lead.
     *
     * @param  array  $lead  Associative array representing Marketo lead
     * @param  string  $lookupField  Field used for deduplication
     * @return \CSD\Marketo\Response\CreateOrUpdateLeadsResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoCreateLeadFailed
     * @link http://developers.marketo.com/documentation/rest/createupdate-leads/
     */
    public function createLead($lead, $lookupField = null)
    {
        $leadFields = config('marketo.fields.prune') ? $this->pruneFields($lead) : $lead;

        $response = $this->client->createLeads([$leadFields], $lookupField);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoCreateLeadFailed($message, $code);
        }

        return $response->getResult();
    }

    /**
     * Create or update lead.
     *
     * @param  array  $lead  Associative array representing Marketo lead
     * @param  string  $lookupField  Field used for deduplication
     * @return \CSD\Marketo\Response\CreateOrUpdateLeadsResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoCreateOrUpdateLeadFailed
     * @link http://developers.marketo.com/documentation/rest/createupdate-leads/
     */
    public function createOrUpdateLead($lead, $lookupField = null)
    {
        $leadFields = config('marketo.fields.prune') ? $this->pruneFields($lead) : $lead;

        $response = $this->client->createOrUpdateLeads([$leadFields], $lookupField);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoCreateOrUpdateLeadFailed($message, $code);
        }

        return $response->getResult();
    }

    /**
     * Update lead.
     *
     * @param  array  $lead  Associative array representing Marketo lead
     * @param  string  $lookupField  Field used for deduplication
     * @return \CSD\Marketo\Response\CreateOrUpdateLeadsResponse
     * @throws \InfusionWeb\Laravel\Marketo\Exceptions\MarketoUpdateLeadFailed
     * @link http://developers.marketo.com/documentation/rest/createupdate-leads/
     */
    public function updateLead($lead, $lookupField = null)
    {
        $leadFields = config('marketo.fields.prune') ? $this->pruneFields($lead) : $lead;

        $response = $this->client->updateLeads([$leadFields], $lookupField);

        if (! $response->isSuccess()) {
            $error = $response->getError();
            $message = $error['message'];
            $code = (int) $error['code'];

            throw new Exceptions\MarketoUpdateLeadFailed($message, $code);
        }

        return $response->getResult();
    }
}
