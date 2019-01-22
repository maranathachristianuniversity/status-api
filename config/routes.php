<?php $routes = [
    "page" => [
        "health/create" => [
            "controller" => "health",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "health/{?}/update" => [
            "controller" => "health",
            "function" => "update",
            "accept" => [
                "POST"
            ]
        ],
        "health/{?}/delete" => [
            "controller" => "health",
            "function" => "delete",
            "accept" => [
                "GET"
            ]
        ],
        "healthstatus/create" => [
            "controller" => "healthstatus",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "healthstatus/{?}/update" => [
            "controller" => "healthstatus",
            "function" => "update",
            "accept" => [
                "POST"
            ]
        ],
        "healthstatus/{?}/delete" => [
            "controller" => "healthstatus",
            "function" => "delete",
            "accept" => [
                "GET"
            ]
        ],
        "storyboards/create" => [
            "controller" => "storyboards",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "storyboards/{?}/update" => [
            "controller" => "storyboards",
            "function" => "update",
            "accept" => [
                "POST"
            ]
        ],
        "storyboards/{?}/delete" => [
            "controller" => "storyboards",
            "function" => "delete",
            "accept" => [
                "GET"
            ]
        ],
        "incidents/create" => [
            "controller" => "incidents",
            "function" => "create",
            "accept" => [
                "POST"
            ]
        ],
        "incidents/{?}/update" => [
            "controller" => "incidents",
            "function" => "update",
            "accept" => [
                "POST"
            ]
        ],
        "incidents/{?}/delete" => [
            "controller" => "incidents",
            "function" => "delete",
            "accept" => [
                "GET"
            ]
        ],
        "notify/{?}" => [
            "controller" => "notify",
            "function" => "notify",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "health/{?}" => [
            "controller" => "reader",
            "function" => "readHealth",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "healthstatus/{?}" => [
            "controller" => "reader",
            "function" => "readHealthStatus",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "incidents/{?}" => [
            "controller" => "reader",
            "function" => "readIncidents",
            "accept" => [
                "GET",
                "POST"
            ]
        ],
        "storyboards/{?}" => [
            "controller" => "reader",
            "function" => "readStoryboards",
            "accept" => [
                "GET",
                "POST"
            ]
        ]
    ],
    "error" => [
        "controller" => "error",
        "function" => "display",
        "accept" => [
            "GET",
            "POST"
        ]
    ],
    "not_found" => [
        "controller" => "error",
        "function" => "notfound",
        "accept" => [
            "GET",
            "POST"
        ]
    ]
]; return $routes;