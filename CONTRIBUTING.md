# Contributing to `sensorario/resources`

Are you sure that no one have been working on your stuff?

## Suggest improvements

 - check if an issue is not already present
 - create if not exists

## Create branch name

    - `[refactoring/]task-description/{destination-branch}`
    - `[feature/]task-description/{destination-branch}`
    - `[fix/]task-description/{destination-branch}`
    - `[enhance/]task-description/{destination-branch}`

### Add new feature on master

Always start with `git checkout -b xxx/{branch} {branch}`. For example, if you need to add new feature:

    - `git checkout -b feature/task-description/master master`

In some cases there are just the needs to add some components. In these case, is suggested enhance branch:

    - `git checkout -b enhance/task-description/master master`

### Fix code fix next major release

Every time you need to refactoring your code to prepare next release or just to make some other tasks:

    - `refactoring/task-description/{destination-branch}`

### Fixes

Every time you need to fix a bug or just apply a little patch

    - `fix/task-description/{destination-branch}`

## Steps

### How to fix some bug

 - select issue
 - create branch named with issue number from right branch
 - fix `CHANGELOG` file
 - code!
 - remember tests if necessary
 - squash all your commits
 - open pull request
 - wait feedback

### How to add new feature

 - select issue
 - create branch named with issue number from master
 - fix `CHANGELOG` file
 - code!
 - remember tests if necessary
 - squash all your commits
 - wait feedback
 - open pull request

### How to release new major release

 - rename master branch to X.0 where X is the new major release
 - remove all deprecated codes
 - keep all tests in green
 - tag branch X.0.0
 - create new master branch

## Accept a pull request

### Accept bug fix

   - remember fix merge message with [close #XXX] message
   - merge on relative minor/master
   - increment patch release number
   - tag branch X.Y.{+1}

### Accept Enhancement

   - create new minor
   - merge on relative minor/master
   - increment minor release number
   - tag branch X.{+1}.0

### Remove deprecations

   - create new major release
   - increment major release number
   - tag branch {+1}.0.0

## Commit message

Always, when a new feature or new fix were added, also `CHANGELOG` should be updated. Commit message should be the same added in `CHANGELOG`.

Commit message must be `[closed #42] - message`
