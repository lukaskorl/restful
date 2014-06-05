<?php

use \Symfony\Component\HttpFoundation\Response;

return array(

    'collection' => array(
        'response' => array(
            'meta' => array(
                'page' => array(
                    'currentPage'   => '{pagination.current_page}',
                    'from'          => '{pagination.from}',
                    'lastPage'      => '{pagination.last_page}',
                    'perPage'       => '{pagination.per_page}',
                    'to'            => '{pagination.to}',
                    'total'         => '{pagination.total}',
                ),
            ),
            'data' => '{payload}',
        ),
        'status_code' => Response::HTTP_OK,
    ),

    'entity' => array(
        'response' => '{payload}',
        'status_code' => Response::HTTP_OK,
    ),

    'created' => array(
        'status_code' => Response::HTTP_CREATED,
    ),

    'updated' => array(
        'status_code' => Response::HTTP_OK,
    ),

    'deleted' => array(
        'status_code' => Response::HTTP_OK,
    ),

    'error' => array(
        'response' => array(
            'error' => array(
                'type' => '{error.type}',
                'message' => '{error.message}',
                'documentationUrl' => '{error.documentation_url}',
                'statusCode' => '{error.status_code}',
            )
        ),
        'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
    ),

    'unauthorized' => array(
        'status_code' => Response::HTTP_UNAUTHORIZED,
    ),

    'not_found' => array(
        'status_code' => Response::HTTP_NOT_FOUND,
    ),

    'forbidden' => array(
        'status_code' => Response::HTTP_FORBIDDEN,
    ),

    'unprocessable' => array(
        'status_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
    ),
);