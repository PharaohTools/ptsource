<?php

$demopipelines = array(
    "pipeline_1" => array(
        "project_slug" => array("label" => "Project Slug:", "value" => "pipeline_1"),
        "project_title" => array("label" => "Project Title:", "value" => "My Project Title"),
        "git_url" => array("label" => "Git URL:", "value" => "http://github.com/PharaohTools/website.git"),
        "project_description" => array("label" => "Project Description:", "value" => "My Project Description. What's the point of this one."),
        "steps" =>
        array(
            array(
                "title" => "Build Step 1",
                "type" => "BashShell",
                // "title" => "Build Step 1",
                "value" => "Lets do a git clone or something" ),
            array(
                "title" => "Build Step 2",
                "type" => "Xvfb",
                // "title" => "Build Step 1",
                "value" => "The second build step. Lets start Xvfb, for instance" ), ), ),
    "other_project" => array(
        "project_slug" => array("label" => "Project Slug:", "value" => "other_project"),
        "project_title" => array("label" => "Project Title:", "value" => "Other Project"),
        "git_url" => array("label" => "Git URL:", "value" => "http://github.com/PharaohTools/otherproject.git"),
        "project_description" => array("label" => "Project Description:", "value" => "Some Other Project Description. What's the point of this one next."),
        "steps" =>
        array(
            array(
                "title" => "Build Step 1",
                "type" => "BashShell",
                // "title" => "Build Step 1",
                "value" => "Lets do a git clone or something" ),
            array(
                "title" => "Build Step 2",
                "type" => "Xvfb",
                // "title" => "Build Step 1",
                "value" => "The second build step. Lets start Xvfb, for instance" ), ), ),
    "cleopatra" => array(
        "project_slug" => array("label" => "Project Slug:", "value" => "cleopatra"),
        "project_title" => array("label" => "Project Title:", "value" => "The Cleopatra Pharaoh Application"),
        "git_url" => array("label" => "Git URL:", "value" => "http://github.com/PharaohTools/cleopatra.git"),
        "project_description" => array("label" => "Project Description:", "value" => "This is Cleopatra, the queen of Configuration Management"),
        "steps" =>
        array(
            array(
                "title" => "Build Step 1",
                "type" => "BashShell",
                // "title" => "Build Step 1",
                "value" => "Lets do a git clone or something" ),
            array(
                "title" => "Build Step 2",
                "type" => "Xvfb",
                // "title" => "Build Step 1",
                "value" => "The second build step. Lets start up 4 operating systems to test on 4, for instance" ), ), ),
    "phlagrant" => array(
        "project_slug" => array("label" => "Project Slug:", "value" => "phlagrant"),
        "project_title" => array("label" => "Project Title:", "value" => "The Phlagrant Pharaoh Application"),
        "git_url" => array("label" => "Git URL:", "value" => "http://github.com/PharaohTools/phlagrant.git"),
        "project_description" => array("label" => "Project Description:", "value" => "This is Phlagrant, the queen of Development Environments"),
        "steps" =>
        array(
            array(
                "title" => "Build Step 1",
                "type" => "BashShell",
                // "title" => "Build Step 1",
                "value" => "Lets do a git clone or something" ),
            array(
                "title" => "Build Step 2",
                "type" => "Xvfb",
                // "title" => "Build Step 1",
                "value" => "The second build step. Lets start Xvfb, for instance" ), ), ),
) ;