# Contributing to `sensorario/resources`

Are you sure that no one have been working on your stuff?

## Suggest improvements

 - check if an issue is not already present
 - create if not exists

## Take care about an issue

### Select right branch name

 - detect destination branch
 - create a branch named like ...
    - `feature|fix/{destination-branch}/description`

### How to fix some bug

 - select issue
 - create branch named with issue number from right branch
 - fix `changelog` file
 - code!
 - remember tests if necessary
 - squash all your commits
 - open pull request
 - wait feedback

### How to add new feature

 - select issue
 - create branch named with issue number from master
 - fix `changelog` file
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

Always, when a new feature or new fix were added, also `CHANGELOG` should be updated. Commit message should be the same added in changelog.

Commit message must be `[closed #42] - message`
