# Famous Quote Quiz

This is test task, i made by custom reqruimenents. 

__Description:__
In the famous quote quiz game system will ask questions and user should try to pick a correct answer. Depending on selected mode user will have to choose correct answer from a list of answers, or simply to answer with Yes/No to the question.

__Task:__
Please create 2 pages:

1. Main page - shows a famous quote quiz
2. Settings page – allows switching between modes.

The user has to guess who the author of the quote is.
The application can function in 2 modes:
  - Binary (Yes/No) – this is the default mode
  - Multiple choice questions – showing three possible answers, one of which must be the right one.

Regardless of the currently selected mode, if the user clicks on the right answer a message is displayed “Correct! The right answer is: ….”; if the user clicks on the wrong answer a message is displayed “Sorry, you are wrong! The right answer is: ….”. Then the answer options disappear and the author name is displayed below the quote. Additionally a button ‘Next’ appears below the author name. When the user clicks ‘Next’ they are navigated to the next quote where they can guess the next quote.
Below you can find 2 wireframes displaying the Main page.


Project information:
-------------
  I build custom PHP API, using Bootstrap 3.0, jQuery, Ajax and PHP-PDO for secure database connection. Escape dangerous tags and possible XSS attack.
  
__I have two tabs on homepage, showing:__
  1. __Quiz preview__ – show all current questions for this test
  2. __Choose mode__ – show option to choose what kind ot questions you will solve: Binary(Yes/No) or Multiple choise. When user choose type, quiz with selected question type is loading with AJAX under form.


Installation:
-------------
  1. Download project ZIP file or clone it via GIT with command:
  
  __HTTPS__
  ```
  git clone https://github.com/krasimirkostadinov/QuoteQuiz.git
  ```
  
  __SSH__
  ```
  git clone git@github.com:krasimirkostadinov/QuoteQuiz.git
  ```
  
  2. Create MySQL database at your setup.
  3. Import "init_db.sql" file from project root folder to your database. This is initial database with just a first quiz with question and answers. 
  4. Configure virtualhost and set execute permission to project root folder (if Linux based).
  5. Please setup your project settings in ./config.php file.
    !important config settings:
    - HOST_PATH - host path (also URL) to your local project. It is used also for loading resource files.
    - DB_USER - user for database connection
    - DB_PASS - user's password for database connection


Project preview:
----------------
  1. Homepage UI, quiz preview
  ![alt tag](/docs/quiz-preview.png?raw=true "Quiz preview")


  2. Choosing question type:
  ![alt tag](/docs/choose-a-type.png "Choose question type")


  3. Question type: Boolean (Yes/No)
  ![alt tag](/docs/question-single-type.png?raw=true "Boolean question")

  4. Question type: Multiple choise
  ![alt tag](/docs/question-multiple-type.png?raw=true "Multiple choise question")

  5. Primary correct answer
  ![alt tag](/docs/primary-right-answer.png?raw=true "Correct answer")

  6. Primary wrong answer
  ![alt tag](/docs/primary-wrong-answer.png?raw=true "Wrong answer")
