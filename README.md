# In File Substring Line Searcher 
*(test work by Umbrellio)*

# Using
 installing:
    git clone
    composer install
 interface:
    `SubstringLineSearcher::__constract($configYamlFileName)`
    `SubstringLineSearcher::loadConfig($configYamlFileName);`
    `SubstringLineSearcher::setConfig($configArray);`
    `SubstringLineSearcher::openFile($fileName);`
    `SubstringLineSearcher::find($stringToFind);`


# TODO:
1. Buffering FileReader subclass
2. Methods
   - findAll()
   - findNext()
3. Cashing of new line position
4. Cashing prev res

# Known problems
1. 

# SQL Test
  `users.sql`