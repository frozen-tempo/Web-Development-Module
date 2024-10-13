## Landing / Login Page
This is the page that new users will first come to, it will include a section to login/signup. This section will also include a preview of webpage features to generate user interest and incentivise signups. This doubles up as the signup page also.

Make sure that the design of this page is clean and not too cluttered.
### Main Functionality
#### Login
1. User inputs login information (email and password) into the provided input fields.
2. User clicks the login button
3. System checks if the username belongs to an existing user, if yes the system then checks that the password provided matches the provided password in the database for that user. If the user does not exist already the user is notified and prompted to sign up.
4. Once login has completed the user is then redirected to their personal main feed.

<u>Pseudocode</u>
BEGIN

entered_email = GET email from input field
entered_password = GET email from input field
encrypted_pw = encrypt(entered_password)

IF entered_email OR entered_password are empty:
	DISPLAY error to user to fill out required field(s)

valid_user = FIND the entered_email in the website database

IF valid_user exists AND encrypted_pw == valid_user.password:
	REDIRECT user to main feed page
ELSE:
	Ask user to enter valid login details
END

BEGIN
IF user clicks "Forgot Password" link:
	REDIRECT to password recovery page
END

BEGIN
IF user clicks "Create Account" link:
	REDIRECT to registration page
	
END
#### Feature Preview
1. Page displays a carousel which shows various different features of the social media site.

BEGIN

GET photos from server
SET current_index to 0

FUNCTION displayCurrentPhoto
	SET current_photo to photos[current_index]
	DISPLAY current_photo

FUNCTION swapToNextPhoto
	SET current_index to current_index + 1
	IF current_index is greater than length of array photos THEN
		SET current_index to 0
	displayCurrentPhoto()

FUNCTION swapToPrevPhoto
	SET current_index to current_index - 1
	IF current_index is less than 0 THEN
		SET current_index to length of array photos - 1
	displayCurrentPhoto()

END
#### Links to Other Pages
1. Links will be provided to various different pages which the user might find useful e.g. Help, FAQ, Contact, Signup, Logout etc.
## Help/FAQ/Contact Pages
This page should provide useful information for the user to assist with queries they might have. Avoid clutter on this page, provide a minimalist design with a focus on the information for the user as the primary page use.
## Signup Page
User is redirected here if they don't already have an account and select to create one. Make sure this is very simple and streamlined, want to minimise barriers to entry as much as possible.
### Main Functionality
#### Account Registration
1. User inputs account information (Name, Phone No, Email, Password, Admin Key (if Applicable) into the input fields provided.
2. User is required to repeat the password input a second time to verify its correctness. There should also be visual indicators for minimum password requirements. 
3. User clicks the register button
4. System first checks if the email provided also exists in the system, if yes then the user is notified and prompted to enter a valid email. If the email does not already exist on the system then the account is successfully created and a verification email is sent to the provided email for user to verify account before they can access.

BEGIN

email = GET email from input box
first_name = GET first name from input box
last_name = GET last name from input box
mobile_number = GET mobile_number from input box
password = GET password from input box
repeat_password = GET repeat_password from input box

FUNCTION validateSignupInformation(email, mobile_number, password, repeat_password)
	INIT error_code = ""
	IF email is empty OR email not in format (xxx@xxx.xxx) THEN
		SET error_code = "Please enter valid email address"
		RETURN false, error_code
	IF existingUser(email) is true THEN
		SET error_code = "Email address already taken by existing user"
		RETURN false, error_code
	IF mobile_number is empty OR NOT in mobile number format THEN
		SET error_code = "Please enter valid mobile number"
		RETURN false, error_code
	IF validatePassword(password) is false THEN
		SET error_code = "Password does not meet security requirements, please retry"
		RETURN false, error_code
	IF password NOT equal to repeat_password THEN
		SET error_code = "Password fields do not match, please check"
		RETURN false, error_code
	RETURN true

FUNCTION validatePassword(password):
	IF password meets requirements (RegEx) THEN
		RETURN true
	ELSE
		RETURN false
	
FUNCTION existingUser(email):
	existing_user = QUERY db for email
	IF existing_user is found THEN
		RETURN true
	RETURN false  

IF validateSignupInformation(email, mobile_number, password, repeat_password) THEN
	DISPLAY "Registration Successful, please check your email to verify before accessing account"
	REDIRECT user to Login Page
ELSE
	DISPLAY error_code
	DISPLAY "Unable to complete registration, please try again"

END
## Main Feed Page
Contains posts from all users followed by the user in a continuous stream which can be scrolled through and interacted with. User can click on profiles to traverse between various pages.
### Main Functionality
#### Post Viewing
BEGIN

user = GET user from current session
main_feed_posts = getUserPosts(user)
SET max_posts_per_page = 25

FUNCTION getUserPosts(user, max_posts_per_page):
	SET user_feed = empty list
	post_list = GET posts from database
	WHILE length of user_feed < max_posts_per_page:
		FOR each post in post_list:
			IF post.author.followers contains user THEN
				add post to user_feed
	RETURN user_feed

DISPLAY main_feed_posts

END
#### Post Commenting

BEGIN

IF comment button is clicked THEN 
	DISPLAY comment input box

comment = GET comment from input box
IF comment is empty THEN
	DISPLAY error "Cannot post empty comment"

FUNCTION postComment(post_id, comment):
	post_comments = GET post.comments from database where post.post_id matches post_id
	Add comment to post.post_comments
	Clear comment input box

FUNCTION deleteComment(post_id, comment_id):
	post_comments = GET post.comments from database
	Remove comment to post_comments
	Clear comment input box

END

#### Post Liking

BEGIN

post_id = GET post_id for liked post
user_likes = GET post_id.user_likes from database

IF user exists in list user_likes THEN
	REMOVE user from post_id.user_likes
	TOGGLE like icon to inactive
ELSE
	ADD user to post_id.user_likes
	TOGGLE like icon to active

END

#### Post Creation/Deletion

BEGIN

FUNCTION createPost():
	post_text = GET text from input field
	IF post_text is empty THEN
		DISPLAY "Cannot post empty post"
		RETURN
	new_post = CREATE a new database entry for the new post with associated metadata

FUNCTION deletePost(post_id):
	DELETE post from database where post.post_id matches post_id

END
#### Navigation to Profiles

BEGIN

User clicks on profile name OR photo
target_profile = GET post.author from database
REDIRECT user to target_profile 

END
## Profile Page
Personal profile page which is unique to each user, these can be viewed in full if the viewing user is friends with the profile page owner they can view the page in full, if not they are able to view a limited version of the page. Users can friend request users from this page and also make posts on the users profile page.
### Main Functionality

#### Post Viewing
BEGIN

user = GET user from current session
profile_id = GET user_id of profile owner
friend_status = QUERY database for user exists in profile_id.friends_list
SET max_posts_per_page = 25
profile_posts = getProfilePosts(user, profile_id, friend_status, max_posts_per_page)

FUNCTION getProfilePosts(user, profile_id, friend_status, max_posts_per_page):
	SET profile_feed = empty list
	IF friend_status is true THEN:
		post_list = GET profile_id.posts from database
		WHILE length of user_feed < max_posts_per_page:
			FOR each post in post_list:
				add post to profile_feed
	RETURN profile_feed

DISPLAY profile_posts

END

#### Post Creation/Deletion
BEGIN

FUNCTION createPost():
	post_text = GET text from input field
	IF post_text is empty THEN
		DISPLAY "Cannot post empty post"
		RETURN
	new_post = CREATE a new database entry for the new post with associated metadata

FUNCTION deletePost(post_id):
	DELETE post from database where post.post_id matches post_id

END
#### Post Commenting
BEGIN

IF comment button is clicked THEN 
	DISPLAY comment input box

comment = GET comment from input box
IF comment is empty THEN
	DISPLAY error "Cannot post empty comment"

FUNCTION postComment(post_id, comment):
	post_comments = GET post.comments from database where post.post_id matches post_id
	Add comment to post.post_comments
	Clear comment input box

FUNCTION deleteComment(post_id, comment_id):
	post_comments = GET post.comments from database
	Remove comment to post_comments
	Clear comment input box

END

#### Friending/Unfriending
BEGIN

user_id = GET user_id from current session
target_profile = GET user_id for owner of profile

FUNCTION friendRequest(user, target_profile):
	user_friend_list = GET user_id.friends_list from database
	target_profile_friend_list = GET target_profile.friends_list from database
	IF target_profile existing in user_friend_list AND user exists in target_profile_friend_list THEN
		DISPLAY error "Already friends with this user"
		RETURN
	ELSE
		send friend request to target_profile from user
		friendship = CREATE friendship entry in the database where:
			friendship_id = uid
			initiator= user_id
			responder = target_profile
			status = "pending"

FUNCTION acceptRequest(request_id):
	friendship_request = GET friendship from database where friendship.friendship_id = request_id
	SET friendship_request.status = "accepted"
	Add friendship_request.responder to friendship_request.initiator.friend_list
	Add friendship_request.initiator to friendship_request.responder.friend_list

FUNCTION declineRequest(request_id):
	friendship_request = GET friendship from database where friendship.friendship_id = request_id
	Remove friendship_request from database

FUNCTION unfriend(user, target_profile):
	friendship_request = GET friendship from database where:
	friendship.initiator = user OR target_profile AND
	friendship.responder = user OR target_profile
	Remove friendship_request from database

END