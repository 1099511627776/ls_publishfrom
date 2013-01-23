Feature: Greeting plugin standart features BDD
    Test base functionality of LiveStreet publishfrom plugin standart

    @mink:selenium2
    Scenario: publishfrom LiveStreet CMS
        #login
        Given I am on "/login"
        	Then I wait "2000"
            Then I want to login as "admin"
			Then I am on "/topic/add"
			Then I fill in "topic_title" with "test topic1"
			Then I fill in "topic_text" with "test descripyion for topic @admin"
			Then I fill in "topic_tags" with "test topic"
			Then the response should contain "<select name=\"publishfrom\">"
			And the response should contain "<option value=\"3\">Friend FullName(user-friend)</option>"
			And the response should contain "<option value=\"2\">Golfer FullName(user-golfer)</option>"
			Then I select "Friend FullName(user-friend)" from "publishfrom"
			Then I press element by css "#submit_topic_publish"
			Then I wait "2000"
			Then print last response
			Then the response should contain "user-friend"


