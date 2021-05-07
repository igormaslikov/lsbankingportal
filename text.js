var request = require("request");

var options = { method: 'POST',
  url: 'https://nz.vedaxml.com/sys1',
  headers: 
   { 'cache-control': 'no-cache',
     'content-type': 'text/xml',
     authorization: 'Basic em1pTXJUeHo4UUFQOlJHYkpSeEF5Wld6Sg==' },
  body: '<?xml version="1.0" encoding="UTF-8"?>\r\n<BCAmessage type="request" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">\r\n<BCAaccess>\r\n<BCAaccess-code>zmiMrTxz8QAP</BCAaccess-code>\r\n<BCAaccess-pwd>RGbJRxAyZWzJ</BCAaccess-pwd>\r\n</BCAaccess>\r\n<BCAservice>\r\n<BCAservice-client-ref>Test001</BCAservice-client-ref>\r\n<BCAservice-code>BCA011</BCAservice-code>\r\n<BCAservice-code-version>V00</BCAservice-code-version>\r\n<BCAservice-data>\r\n<request version="V2.0" mode="production" transaction-reference="1909-1156">\r\n<access-purpose code="C2"/>\r\n<client-details>\r\n<client-identifier>032512</client-identifier>\r\n<operator-id>xmlsan</operator-id>\r\n</client-details>\r\n<product ewp="yes" driver-licence="yes" name="consumer-enquiry-nz" propertyownership="yes" score="yes" summary="yes" licencecheck="yes" moj-fines="yes" />\r\n<individual>\r\n<individual-name>\r\n<family-name>Sample</family-name>\r\n<first-given-name>Amelia</first-given-name>\r\n<other-given-name>Ingrid</other-given-name>\r\n</individual-name>\r\n<gender type="female"/>\r\n<date-of-birth>1987-05-16</date-of-birth>\r\n<address type="current">\r\n<street-number>42</street-number>\r\n<street-name>Hopetoun</street-name>\r\n<street-type code="ST"/>\r\n<suburb>Ponsonby</suburb>\r\n<city>Auckland</city>\r\n</address>\r\n<employment>\r\n<employer>Big Pies Ltd</employer>\r\n<occupation>Pie Maker</occupation>\r\n</employment>\r\n<phone-details>\r\n<phone-area-code>0009</phone-area-code>\r\n<phone-number>08175456</phone-number>\r\n</phone-details>\r\n<driver-licence-details>\r\n<licence-number>AB345678</licence-number>\r\n <licence-version-number>003</licence-version-number>\r\n</driver-licence-details>\r\n</individual>\r\n<enquiry consent="yes" guarantor="no" joint-account="yes">\r\n<account-type code="CC"/>\r\n<enquiry-amount>2500</enquiry-amount>\r\n<client-reference>REF55487556</client-reference>\r\n</enquiry>\r\n</request>\r\n</BCAservice-data>\r\n</BCAservice>\r\n</BCAmessage>' };

request(options, function (error, response, body) {
  if (error) throw new Error(error);

  console.log(body);
});
