# coloftechThemePlugin

A. How to use it?
1. clone/download and extract the zip file. 
2. copy the whole folder of coloftech to plugins/theme
3. open your journal website and change to coloftech (child theme)


B. How to edit the image slider?
1. inside coloftech folder go to /templates/frontend/pages
2. Find the journal1.tpl and edit the information
3. Open slider.tpl and change the id # to you journal id number

C. How to check what the journal id number of your active journal?

1. add this code  {$journalId } inside the journal1.tpl or between this line
 
  <h3>
                   Journal Editors {$journalId }</h3>

D. What if you have more than one journal?
1. Just create new tpl file and name it in your desired name or like this journal2.tpl then follow step C.
