---
title: Overlook
description: Add a dashboard widget to a Filament panel showing record counts for every resource.
---

# Overlook

Overlook is a Filament widget that gives a panel's dashboard an at-a-glance summary: one card per resource, each showing how many records exist and linking to that resource's list page.

It is the view you want at the top of a dashboard — how many orders, how many users, how many posts — without building a stat widget for each one by hand.

## What appears

By default, every resource registered with the current panel gets a card. Two things narrow that:

1. **Authorization.** Each resource's `canViewAny()` is checked, so a user only sees counts for things they are allowed to look at.
2. **Your own list.** You can restrict the set with [includes or excludes](configuration.md).

Each card shows the resource's plural model label, its navigation icon, and the record count, and links to the resource's index page.

## How counts are produced

Overlook calls each resource's own `getEloquentQuery()` and counts the result. Because that is the same query the resource's table is built from, any global scopes or query customisation you already have are respected — the count matches what the user would see on the list page.

Counts are read live each time the widget renders, one query per resource. On a panel with a great many resources, or tables large enough that counting is slow, that is worth knowing about.

Large numbers are abbreviated — 1,200 records show as `1K` — with the exact figure available on hover. Both behaviours can be [turned off](configuration.md).

## What you can change

- **[Configuration](configuration.md)** — layout, ordering, which resources appear, count formatting, and icons.
- **[Customizing resources](customizing-resources.md)** — override the query or title for an individual resource.

## Next steps

Start with [Installation](installation.md).
