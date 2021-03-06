<?php

/**
 * Supply the basis for the navbar as an array.
 */

return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Frågor",
            "url" => "question",
            "title" => "Frågor och svar",
        ],
        [
            "text" => "Taggar",
            "url" => "tags",
            "title" => "Taggar",
        ],
        [
            "text" => "Om",
            "url" => "about",
            "title" => "Om",
        ],
        [
            "text" => "Användare",
            "url" => "user",
            "title" => "Användare",
        ],
    ],
];
