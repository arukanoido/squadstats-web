<?php

namespace App;

use Aws\AwsClient;

class Athena 
{

    public function __construct(AwsClient $athenaClient)
    {
        $this->athenaClient = $athenaClient;
    }

    public function query($queryString)
    {
        $response = $this->athenaClient->startQueryExecution([
            'QueryString' => $queryString, // REQUIRED
            'ResultConfiguration' => [
                'OutputLocation' => 's3://aws-athena-query-results-972380143313-us-west-2',
            ],
        ]);
        $queryId = $response["QueryExecutionId"];
        $status = "RUNNING";

        while ($status == "RUNNING") {

            usleep(500 * 1000);

            $result = $this->athenaClient->getQueryExecution([
                'QueryExecutionId' => $queryId, // REQUIRED
            ]);
            $status = $result["QueryExecution"]["Status"]["State"];
        }

        $result = $this->athenaClient->getQueryResults([
            'QueryExecutionId' => $queryId, // REQUIRED
        ]);
        return $result["ResultSet"];
    }
}