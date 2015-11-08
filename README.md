# OpenUG

A web app for user groups.

## Status

This app is currently being developed. It isn't ready yet.

## How To

## Add Pages

`content/page/{id}.md`

Example `content/page/index.md`:

```md
---
title: Welcome to our meetup group
description: We meet occasionally
---

# Welcome to our meetup group

## We meet occasionally

This is some welcome text. This is some welcome text.
```

## Add Events

`content/event/{id}.md`

`{id}` must contain the `Y-m-d` prefix.

Example `content/page/2015-12-25-christmas-meetup.md`:

```md
---
title: Christmas Meetup
description: We are all meeting at Christmas!
joind.in: http://joind.in/fooooo
meetup: http://meetup.com/brap
talks:
    - @talk:fire-drone
---

# Christmas Meetup

Come and join us on Christmas day!
```

## Add Talks

`content/talk/{id}.md`

Example `content/talk/fire-drone.md`:

```md
---
title: How to create a drone that spits fire
speaker: @speaker:alice
event: @event:2015-12-25-christmas-meetup
joind.in: http://joind.in/blah
---

Learn how to create a fire spitting drone using a Raspberry PI, 10 hair dryers and some tweezers.
```

## Add Speakers

`content/speaker/{id}.md`

Example `content/speaker/alice.md`:

```md
---
name: Alice
from: United Kingdom
skills: PHP, HTML, CSS, JS
talks:
    - @talk:fire-drone
---

Alice is a student of some university. In her spare time she saves polar bears and creates drones that spit fire.
```
