<?php
return [
    // The folders that are visible within the library.
    // Currently we can display just folder one level deep in your templates folder
    "compFolders" => [
        "_atoms",
        "_molecules",
        "_organisms",
        "_embeds",
        "_views"
    ],
    // The different buttons to resize the iFrame.
    // It's up to you to motifie this sizes
    "mqButtons" => [
        "min" => "320px",
        "xs" => "400px",
        "s" => "600px",
        "m" => "800px",
        "l" => "1000px",
        "max" => "1440px",
        "fluid" => "100vw"
    ],
    // The different component statusses for your components
    // Create your own or start with the following
    "compStatus" => [
        0 => ["name" => "wip", "color" => "#FF9800"],
        1 => ["name" => "review", "color" => "#369BF4"],
        2 => ["name" => "done", "color" => "#4CAF50"],
        3 => ["name" => "discarded", "color" => "#F44336"],
    ],
];
