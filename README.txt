Tool for transcribing Olympus sessions
--------------------------------------
[201205] (air)
[201408] (air) revised

To use:

1) Place this folder somewhere in your htdocs/ folder

2) For each domain you want to work with, link to the same level.
For example:

    mklink /J hoodomain F:\hoodomain\logs\hoodomain

so that the top-level folder has:
   ...
   hoodomain\ [symlink]
   WebTranscription\
   ...

3) use a browser to navigate to http://www.yourserver.com/WebTranscription/tool.php
	- not all browsers behave exactly the same, but it should work.

4) enter the coordinates of your target session in the fields

5) start transcribing!
   - click the audio widget to hear an utterance
   - .trans files are updated immediately
5a) Some pointers
   - non-lexical items should go in square brackets; e.g. [NOISE], [CLICK], etc
   - there is no definitive set of non-lexicals... be conservative
   - there is no spell-checking at this point, so be careful.


----
