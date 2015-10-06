# lsrw_cms (v9.10)
## Introduction
lsrw_cms Introduction...

## Documentation
### Classes
#### User Object

        $User = new User( $target );
        $User -> id = Returns the $target User's ID (Int)
        $User -> name = Returns the $target User's Name (String)
        $User -> display = Returns the $target User's Display Name (String)
        $User -> twitter = Returns the $target User's Twitter Name (String)
        $User -> twitter_id = Returns the $target User's Twitter ID (String)
        $User -> permissions = Returns the $target User's Permissions (Array)
        $User -> created = Returns the $target User's Creation Date (Date Object)
        $User -> exists = Returns true if $target User exists, false if not (Boolean)

| Property | Description          |
| ------------- | ----------- |
| $User -> id   | Returns the $target User's ID (Int)   |
| $User -> name | _Closes_ a window     |

### Page Object

        $Page = new Page( $target );
        $Page -> id = Returns the $target Page's ID (Int)
        $Page -> title = Returns the $target Page's Title (String)
        $Page -> content = Returns the $target Page's Content (Text)
        $Page -> author = Returns the $target Page's Author (User Object)
        $Page -> modified_author = Returns the $target Page's Last Editor (User Object)
        $Page -> modified = Returns the $target Page's Last Update Date (Date Object)
        $Page -> keywords = Returns the $target Page's Keywords (Array)
        $Page -> description = Returns the $target Page's Description (Text)
        $Page -> created = Returns the $target Page's Creation Date (Date Object)
        $Page -> exists = Returns true if $target Page exists, false if not (Boolean)

### Functions
