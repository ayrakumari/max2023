*/5 * * * * curl -s "http://10.10.9.26/api/setOrderStagesApi" > /dev/null

*/8 * * * * curl -s "http://10.10.9.26/api/setOrderStagesApiV1" > /dev/null

*/20 * * * * curl -s "http://10.10.9.26/api/setSinceFromApiV1" > /dev/null

0 11 * * *  curl -s "http://10.10.9.26/api/getOrderStagesDelayAPIV1" > /dev/null


*/20 * * * * curl -s "http://10.10.9.26/api/getIndiaMartData" > /dev/null


*/25 * * * * curl -s "http://10.10.9.26/api/getIndiaMartData_2" > /dev/null

*/30 * * * * curl -s "http://10.10.9.26/api/getIndiaMartData_3" > /dev/null


*/15 * * * * curl -s "http://10.10.9.29/api/setAjaxRunCronjonLeadCOUNT" > /dev/null



*/20 * * * * curl -s "http://10.10.9.29/api/setAjaxRunCronjonLeadGraph" > /dev/null


*/30 * * * * curl -s "http://10.10.9.29/api/sendEmailSMS2Lead"> /dev/null

59 11  * * * curl -s "http://10.10.9.29/api/sendEmail_forSampleNotification" > /dev/null

*/20 * * * * curl -s "http://10.10.9.29/api/sendEmailSMS2Lead_PACKING"> /dev/null

*/40 * * * * curl -s "http://10.10.9.29/api/getIndiaMartData_4" > /dev/null

