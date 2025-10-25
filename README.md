# Hours Export - Time Tracking Application

A simple Laravel-based time tracking application that allows users to track work sessions across different projects and export them to Excel. 

## Features

-  **Project Management** - Create and manage multiple projects
-  **Task Tracking** - Add tasks to projects with descriptions
-  **Time Sessions** - Track start/stop times for each task
-  **Excel Export** - Export worked hours organized by day of the week
-  **Auto-calculation** - Automatic calculation of total worked time per project

## Excel Export Format

(At the moment in Dutch but i will change the option for language)

Exported files are organized by weekday in Dutch format: (simple recreation)
```
Van         Tot         Werkzaamheden       Uren
Maandag
09:00:00    12:00:00    Backend work        3u 0m
13:00:00    17:00:00    Testing             4u 0m
conclusie maandag:

Dinsdag
10:00:00    12:30:00    Meeting             2u 30m
conclusie dinsdag:

Woensdag
...
```


## Important Notes

I created this project because I wanted to make this. It is NOT bug free. A lot probably does not work but feel free to open a PR or an Issue.
