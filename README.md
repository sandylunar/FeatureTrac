# FeatureTrac
## TODO
1. Construct Candidate Feature Trees<br>
  1.1 What attributs should the FR tree nodes have?<br>
  1.2 Resources: <br>
    1.2.1 User Manuals(How to deal with docs in all historical versions?)<br>
    1.2.2 Release Notes<br>
    1.2.3 Pull Requests<br>
    1.2.4 Merged FR<br>

2. Merge Feature Trees<br>
How to deal with the difference between components and TOC?

3. Do experiment on Hibernate: Given a new feature request, find out whether it is a redundant or not.<br>
  3.1 Collect 5393+ feature request data from Hibernate Community<br>
  3.2 Retrive redundant feature requests using keywords<br>
  3.3 Review retrived results and identify real redundant FRs<br>
  3.4 Decide redundant feature request<br>

### 3.1 Collect 5393+ feature request data from Hibernate Community(==Done==)
@iscas-lee will finish this before Jan 11 (Beijing Time) <br>
`Target repository`: https://hibernate.atlassian.net/browse/HHH-11370?filter=-4&jql=project%20in%20(OGM%2C%20HHH%2C%20HSEARCH%2C%20HBX%2C%20HV)%20AND%20issuetype%20in%20(Improvement%2C%20"New%20Feature"%2C%20"Remove%20Feature")%20order%20by%20created%20DESC<br>

### 3.2. Retrive and label redundant feature requests(==will be ready before 20170113==)
@iscas-lee<br>
Keywords in the FR comments: What other keywords should we include?
* DO: "does what you want"，"does exactly what is described here", "been done", "We do this via"
* ALREADY: "already exist", "already support", "already add", "already been addressed", "support that already", "Already there"

