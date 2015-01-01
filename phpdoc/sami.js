(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '    <ul>                <li data-name="namespace:MimeMailer" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MimeMailer.html">MimeMailer</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="namespace:MimeMailer_Transport" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MimeMailer/Transport.html">Transport</a>                    </div>                    <div class="bd">                            <ul>                <li data-name="class:MimeMailer_Transport_MailTransport" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="MimeMailer/Transport/MailTransport.html">MailTransport</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:MimeMailer_AbstractMailerAware" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/AbstractMailerAware.html">AbstractMailerAware</a>                    </div>                </li>                            <li data-name="class:MimeMailer_CacheInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/CacheInterface.html">CacheInterface</a>                    </div>                </li>                            <li data-name="class:MimeMailer_Helper" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/Helper.html">Helper</a>                    </div>                </li>                            <li data-name="class:MimeMailer_Mailer" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/Mailer.html">Mailer</a>                    </div>                </li>                            <li data-name="class:MimeMailer_MessageInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/MessageInterface.html">MessageInterface</a>                    </div>                </li>                            <li data-name="class:MimeMailer_MimeMessage" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/MimeMessage.html">MimeMessage</a>                    </div>                </li>                            <li data-name="class:MimeMailer_SpoolInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/SpoolInterface.html">SpoolInterface</a>                    </div>                </li>                            <li data-name="class:MimeMailer_SpoolManager" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/SpoolManager.html">SpoolManager</a>                    </div>                </li>                            <li data-name="class:MimeMailer_TransportInterface" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="MimeMailer/TransportInterface.html">TransportInterface</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    {"type": "Namespace", "link": "MimeMailer.html", "name": "MimeMailer", "doc": "Namespace MimeMailer"},{"type": "Namespace", "link": "MimeMailer/Transport.html", "name": "MimeMailer\\Transport", "doc": "Namespace MimeMailer\\Transport"},
            {"type": "Interface", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/CacheInterface.html", "name": "MimeMailer\\CacheInterface", "doc": "&quot;A classic cache interface&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\CacheInterface", "fromLink": "MimeMailer/CacheInterface.html", "link": "MimeMailer/CacheInterface.html#method_cacheFile", "name": "MimeMailer\\CacheInterface::cacheFile", "doc": "&quot;Must create a new version of a file in cache&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\CacheInterface", "fromLink": "MimeMailer/CacheInterface.html", "link": "MimeMailer/CacheInterface.html#method_isCachedFile", "name": "MimeMailer\\CacheInterface::isCachedFile", "doc": "&quot;Test if a version of a file exists in cache&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\CacheInterface", "fromLink": "MimeMailer/CacheInterface.html", "link": "MimeMailer/CacheInterface.html#method_getCachedFile", "name": "MimeMailer\\CacheInterface::getCachedFile", "doc": "&quot;Get the cached version of a file&quot;"},
            
            {"type": "Interface", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/MessageInterface.html", "name": "MimeMailer\\MessageInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_set", "name": "MimeMailer\\MessageInterface::set", "doc": "&quot;Global setter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_get", "name": "MimeMailer\\MessageInterface::get", "doc": "&quot;Global getter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_clear", "name": "MimeMailer\\MessageInterface::clear", "doc": "&quot;Global variable clearer&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_getId", "name": "MimeMailer\\MessageInterface::getId", "doc": "&quot;Get message ID&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_getMessage", "name": "MimeMailer\\MessageInterface::getMessage", "doc": "&quot;Get the full built message&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setFrom", "name": "MimeMailer\\MessageInterface::setFrom", "doc": "&quot;Set From field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setTo", "name": "MimeMailer\\MessageInterface::setTo", "doc": "&quot;Set To field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setCc", "name": "MimeMailer\\MessageInterface::setCc", "doc": "&quot;Set Cc field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setBcc", "name": "MimeMailer\\MessageInterface::setBcc", "doc": "&quot;Set Bcc field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setAttachment", "name": "MimeMailer\\MessageInterface::setAttachment", "doc": "&quot;Set mail file attachment&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setSubject", "name": "MimeMailer\\MessageInterface::setSubject", "doc": "&quot;Set mail object&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setText", "name": "MimeMailer\\MessageInterface::setText", "doc": "&quot;Set plain text version&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setHtml", "name": "MimeMailer\\MessageInterface::setHtml", "doc": "&quot;Set HTML version&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setReplyTo", "name": "MimeMailer\\MessageInterface::setReplyTo", "doc": "&quot;Set Reply-To header field&quot;"},
            
            {"type": "Interface", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/SpoolInterface.html", "name": "MimeMailer\\SpoolInterface", "doc": "&quot;The spooling management class&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_setSpoolDirectory", "name": "MimeMailer\\SpoolInterface::setSpoolDirectory", "doc": "&quot;Set the spooled mails directory&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_setOrderBy", "name": "MimeMailer\\SpoolInterface::setOrderBy", "doc": "&quot;Set the spooled files ordering rule&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_addMessageToSpool", "name": "MimeMailer\\SpoolInterface::addMessageToSpool", "doc": "&quot;Add a message to spool mails&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_getMessageFromSpool", "name": "MimeMailer\\SpoolInterface::getMessageFromSpool", "doc": "&quot;Get a message from spool mails by ID&quot;"},
            
            {"type": "Interface", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/TransportInterface.html", "name": "MimeMailer\\TransportInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\TransportInterface", "fromLink": "MimeMailer/TransportInterface.html", "link": "MimeMailer/TransportInterface.html#method_validate", "name": "MimeMailer\\TransportInterface::validate", "doc": "&quot;Validate this transport way&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\TransportInterface", "fromLink": "MimeMailer/TransportInterface.html", "link": "MimeMailer/TransportInterface.html#method_transport", "name": "MimeMailer\\TransportInterface::transport", "doc": "&quot;Real transport&quot;"},
            
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/AbstractMailerAware.html", "name": "MimeMailer\\AbstractMailerAware", "doc": "&quot;Extend an object to be &lt;code&gt;\\MimeMailer\\Mailer&lt;\/code&gt; aware&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\AbstractMailerAware", "fromLink": "MimeMailer/AbstractMailerAware.html", "link": "MimeMailer/AbstractMailerAware.html#method_getMailer", "name": "MimeMailer\\AbstractMailerAware::getMailer", "doc": "&quot;Get the mailer instance&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/CacheInterface.html", "name": "MimeMailer\\CacheInterface", "doc": "&quot;A classic cache interface&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\CacheInterface", "fromLink": "MimeMailer/CacheInterface.html", "link": "MimeMailer/CacheInterface.html#method_cacheFile", "name": "MimeMailer\\CacheInterface::cacheFile", "doc": "&quot;Must create a new version of a file in cache&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\CacheInterface", "fromLink": "MimeMailer/CacheInterface.html", "link": "MimeMailer/CacheInterface.html#method_isCachedFile", "name": "MimeMailer\\CacheInterface::isCachedFile", "doc": "&quot;Test if a version of a file exists in cache&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\CacheInterface", "fromLink": "MimeMailer/CacheInterface.html", "link": "MimeMailer/CacheInterface.html#method_getCachedFile", "name": "MimeMailer\\CacheInterface::getCachedFile", "doc": "&quot;Get the cached version of a file&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/Helper.html", "name": "MimeMailer\\Helper", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_mailTagger", "name": "MimeMailer\\Helper::mailTagger", "doc": "&quot;Build a person string compliant to RFC2822&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_mailListTagger", "name": "MimeMailer\\Helper::mailListTagger", "doc": "&quot;Build a list of person strings compliant to RFC2822&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_headerTagger", "name": "MimeMailer\\Helper::headerTagger", "doc": "&quot;Build a mail header tag compliant to RFC2822&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_listAddresses", "name": "MimeMailer\\Helper::listAddresses", "doc": "&quot;Build a list of name=&gt;email pairs compliant to RFC2822&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_formatText", "name": "MimeMailer\\Helper::formatText", "doc": "&quot;Format a text with a special encoding&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_getMimeType", "name": "MimeMailer\\Helper::getMimeType", "doc": "&quot;Search the MIME type of a file&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_html2text", "name": "MimeMailer\\Helper::html2text", "doc": "&quot;Converts HTML to plain text&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_deduplicate", "name": "MimeMailer\\Helper::deduplicate", "doc": "&quot;De-duplicate a set of name=&gt;email pairs to let each email just once&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_checkPeopleArgs", "name": "MimeMailer\\Helper::checkPeopleArgs", "doc": "&quot;Clean and build a set of name=&gt;email pairs&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_charAscii", "name": "MimeMailer\\Helper::charAscii", "doc": "&quot;Returns the ASCII equivalent of a character&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_isAscii", "name": "MimeMailer\\Helper::isAscii", "doc": "&quot;ASCII validator&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Helper", "fromLink": "MimeMailer/Helper.html", "link": "MimeMailer/Helper.html#method_isEmail", "name": "MimeMailer\\Helper::isEmail", "doc": "&quot;Check if an email address is valid&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/Mailer.html", "name": "MimeMailer\\Mailer", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setOptions", "name": "MimeMailer\\Mailer::setOptions", "doc": "&quot;Set an array of options&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setOption", "name": "MimeMailer\\Mailer::setOption", "doc": "&quot;Set the value of a specific option&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getOptions", "name": "MimeMailer\\Mailer::getOptions", "doc": "&quot;Get the array of options&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getOption", "name": "MimeMailer\\Mailer::getOption", "doc": "&quot;Get the value of a specific option&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getDefault", "name": "MimeMailer\\Mailer::getDefault", "doc": "&quot;Get the value of a specific option&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_addError", "name": "MimeMailer\\Mailer::addError", "doc": "&quot;Add error&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getErrors", "name": "MimeMailer\\Mailer::getErrors", "doc": "&quot;Get the errors&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_addInfo", "name": "MimeMailer\\Mailer::addInfo", "doc": "&quot;Add info&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getInfos", "name": "MimeMailer\\Mailer::getInfos", "doc": "&quot;Get the informations&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setRegistry", "name": "MimeMailer\\Mailer::setRegistry", "doc": "&quot;Set a registry entry&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getRegistry", "name": "MimeMailer\\Mailer::getRegistry", "doc": "&quot;Get a registry entry&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_addMessage", "name": "MimeMailer\\Mailer::addMessage", "doc": "&quot;Build a new message&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getMessage", "name": "MimeMailer\\Mailer::getMessage", "doc": "&quot;Get a message by id or current message&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setTransporter", "name": "MimeMailer\\Mailer::setTransporter", "doc": "&quot;Set a transporter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getTransporter", "name": "MimeMailer\\Mailer::getTransporter", "doc": "&quot;Get the transporter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setSpooler", "name": "MimeMailer\\Mailer::setSpooler", "doc": "&quot;Set a spooler manager&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getSpooler", "name": "MimeMailer\\Mailer::getSpooler", "doc": "&quot;Get the spooler&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setDryRun", "name": "MimeMailer\\Mailer::setDryRun", "doc": "&quot;Make a dry run of the class : no mail will be sent&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getDryRun", "name": "MimeMailer\\Mailer::getDryRun", "doc": "&quot;Get the dry run value&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_isDryRun", "name": "MimeMailer\\Mailer::isDryRun", "doc": "&quot;Is it dry run?&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setSpool", "name": "MimeMailer\\Mailer::setSpool", "doc": "&quot;Activate emails spooling&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getSpool", "name": "MimeMailer\\Mailer::getSpool", "doc": "&quot;Get the spool value&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_isSpool", "name": "MimeMailer\\Mailer::isSpool", "doc": "&quot;Is it spooling?&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_setSpoolDirectory", "name": "MimeMailer\\Mailer::setSpoolDirectory", "doc": "&quot;Set the spooled mails directory&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_getSpoolDirectory", "name": "MimeMailer\\Mailer::getSpoolDirectory", "doc": "&quot;Get the spooled mails directory&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_send", "name": "MimeMailer\\Mailer::send", "doc": "&quot;Messages sender&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Mailer", "fromLink": "MimeMailer/Mailer.html", "link": "MimeMailer/Mailer.html#method_spool", "name": "MimeMailer\\Mailer::spool", "doc": "&quot;Messages spooler : prepare the whole content and write it in a file&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/MessageInterface.html", "name": "MimeMailer\\MessageInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_set", "name": "MimeMailer\\MessageInterface::set", "doc": "&quot;Global setter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_get", "name": "MimeMailer\\MessageInterface::get", "doc": "&quot;Global getter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_clear", "name": "MimeMailer\\MessageInterface::clear", "doc": "&quot;Global variable clearer&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_getId", "name": "MimeMailer\\MessageInterface::getId", "doc": "&quot;Get message ID&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_getMessage", "name": "MimeMailer\\MessageInterface::getMessage", "doc": "&quot;Get the full built message&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setFrom", "name": "MimeMailer\\MessageInterface::setFrom", "doc": "&quot;Set From field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setTo", "name": "MimeMailer\\MessageInterface::setTo", "doc": "&quot;Set To field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setCc", "name": "MimeMailer\\MessageInterface::setCc", "doc": "&quot;Set Cc field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setBcc", "name": "MimeMailer\\MessageInterface::setBcc", "doc": "&quot;Set Bcc field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setAttachment", "name": "MimeMailer\\MessageInterface::setAttachment", "doc": "&quot;Set mail file attachment&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setSubject", "name": "MimeMailer\\MessageInterface::setSubject", "doc": "&quot;Set mail object&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setText", "name": "MimeMailer\\MessageInterface::setText", "doc": "&quot;Set plain text version&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setHtml", "name": "MimeMailer\\MessageInterface::setHtml", "doc": "&quot;Set HTML version&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MessageInterface", "fromLink": "MimeMailer/MessageInterface.html", "link": "MimeMailer/MessageInterface.html#method_setReplyTo", "name": "MimeMailer\\MessageInterface::setReplyTo", "doc": "&quot;Set Reply-To header field&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/MimeMessage.html", "name": "MimeMailer\\MimeMessage", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method___construct", "name": "MimeMailer\\MimeMessage::__construct", "doc": "&quot;Construction of a MimeEmail object&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_set", "name": "MimeMailer\\MimeMessage::set", "doc": "&quot;Global setter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_get", "name": "MimeMailer\\MimeMessage::get", "doc": "&quot;Global getter&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_clear", "name": "MimeMailer\\MimeMessage::clear", "doc": "&quot;Global variable clearer&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_getFormated", "name": "MimeMailer\\MimeMessage::getFormated", "doc": "&quot;Get a fromated address info (name &lt;email&gt;) for &lt;code&gt;$name&lt;\/code&gt; field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_getId", "name": "MimeMailer\\MimeMessage::getId", "doc": "&quot;Get message ID&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setFrom", "name": "MimeMailer\\MimeMessage::setFrom", "doc": "&quot;Set From field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setTo", "name": "MimeMailer\\MimeMessage::setTo", "doc": "&quot;Set To field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setCc", "name": "MimeMailer\\MimeMessage::setCc", "doc": "&quot;Set Cc field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setBcc", "name": "MimeMailer\\MimeMessage::setBcc", "doc": "&quot;Set Bcc field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setAttachment", "name": "MimeMailer\\MimeMessage::setAttachment", "doc": "&quot;Set mail file attachment&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setSubject", "name": "MimeMailer\\MimeMessage::setSubject", "doc": "&quot;Set mail object&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setText", "name": "MimeMailer\\MimeMessage::setText", "doc": "&quot;Set plain text version&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setHtml", "name": "MimeMailer\\MimeMessage::setHtml", "doc": "&quot;Set HTML version&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setReplyTo", "name": "MimeMailer\\MimeMessage::setReplyTo", "doc": "&quot;Set Reply-To header field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setFollowupTo", "name": "MimeMailer\\MimeMessage::setFollowupTo", "doc": "&quot;Set Foolowup-To header field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setErrorsTo", "name": "MimeMailer\\MimeMessage::setErrorsTo", "doc": "&quot;Set Errors-To header field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setDispositionNotificationTo", "name": "MimeMailer\\MimeMessage::setDispositionNotificationTo", "doc": "&quot;Set Disposition-Notification-To header field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setAbuseReportsTo", "name": "MimeMailer\\MimeMessage::setAbuseReportsTo", "doc": "&quot;Set Abuse-Reports-To header field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_setReturnReceiptTo", "name": "MimeMailer\\MimeMessage::setReturnReceiptTo", "doc": "&quot;Set Return-Receipt-To header field&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_getMessage", "name": "MimeMailer\\MimeMessage::getMessage", "doc": "&quot;Get sent built message&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_buildMessage", "name": "MimeMailer\\MimeMessage::buildMessage", "doc": "&quot;Message builder&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_makeBoundary", "name": "MimeMailer\\MimeMessage::makeBoundary", "doc": "&quot;Build a boundary value&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\MimeMessage", "fromLink": "MimeMailer/MimeMessage.html", "link": "MimeMailer/MimeMessage.html#method_substitution", "name": "MimeMailer\\MimeMessage::substitution", "doc": "&quot;Make a basic substitution in the object body&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/SpoolInterface.html", "name": "MimeMailer\\SpoolInterface", "doc": "&quot;The spooling management class&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_setSpoolDirectory", "name": "MimeMailer\\SpoolInterface::setSpoolDirectory", "doc": "&quot;Set the spooled mails directory&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_setOrderBy", "name": "MimeMailer\\SpoolInterface::setOrderBy", "doc": "&quot;Set the spooled files ordering rule&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_addMessageToSpool", "name": "MimeMailer\\SpoolInterface::addMessageToSpool", "doc": "&quot;Add a message to spool mails&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolInterface", "fromLink": "MimeMailer/SpoolInterface.html", "link": "MimeMailer/SpoolInterface.html#method_getMessageFromSpool", "name": "MimeMailer\\SpoolInterface::getMessageFromSpool", "doc": "&quot;Get a message from spool mails by ID&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/SpoolManager.html", "name": "MimeMailer\\SpoolManager", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method___construct", "name": "MimeMailer\\SpoolManager::__construct", "doc": "&quot;Construction of a MimeEmail object&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_setSpoolDirectory", "name": "MimeMailer\\SpoolManager::setSpoolDirectory", "doc": "&quot;Set the spooled mails directory&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_getSpoolDirectory", "name": "MimeMailer\\SpoolManager::getSpoolDirectory", "doc": "&quot;Get the spooled mails directory&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_setOrderBy", "name": "MimeMailer\\SpoolManager::setOrderBy", "doc": "&quot;Set the spooled files ordering rule&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_addMessageToSpool", "name": "MimeMailer\\SpoolManager::addMessageToSpool", "doc": "&quot;Add a message to spool mails&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_getMessageFromSpool", "name": "MimeMailer\\SpoolManager::getMessageFromSpool", "doc": "&quot;Get a message from spool mails by ID&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_cacheFile", "name": "MimeMailer\\SpoolManager::cacheFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_isCachedFile", "name": "MimeMailer\\SpoolManager::isCachedFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_getCachedFile", "name": "MimeMailer\\SpoolManager::getCachedFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_encodeFilename", "name": "MimeMailer\\SpoolManager::encodeFilename", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_rewind", "name": "MimeMailer\\SpoolManager::rewind", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_current", "name": "MimeMailer\\SpoolManager::current", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_key", "name": "MimeMailer\\SpoolManager::key", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_next", "name": "MimeMailer\\SpoolManager::next", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\SpoolManager", "fromLink": "MimeMailer/SpoolManager.html", "link": "MimeMailer/SpoolManager.html#method_valid", "name": "MimeMailer\\SpoolManager::valid", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer", "fromLink": "MimeMailer.html", "link": "MimeMailer/TransportInterface.html", "name": "MimeMailer\\TransportInterface", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\TransportInterface", "fromLink": "MimeMailer/TransportInterface.html", "link": "MimeMailer/TransportInterface.html#method_validate", "name": "MimeMailer\\TransportInterface::validate", "doc": "&quot;Validate this transport way&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\TransportInterface", "fromLink": "MimeMailer/TransportInterface.html", "link": "MimeMailer/TransportInterface.html#method_transport", "name": "MimeMailer\\TransportInterface::transport", "doc": "&quot;Real transport&quot;"},
            
            {"type": "Class", "fromName": "MimeMailer\\Transport", "fromLink": "MimeMailer/Transport.html", "link": "MimeMailer/Transport/MailTransport.html", "name": "MimeMailer\\Transport\\MailTransport", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "MimeMailer\\Transport\\MailTransport", "fromLink": "MimeMailer/Transport/MailTransport.html", "link": "MimeMailer/Transport/MailTransport.html#method___construct", "name": "MimeMailer\\Transport\\MailTransport::__construct", "doc": "&quot;Define the &lt;code&gt;sendmail&lt;\/code&gt; path if so&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Transport\\MailTransport", "fromLink": "MimeMailer/Transport/MailTransport.html", "link": "MimeMailer/Transport/MailTransport.html#method_validate", "name": "MimeMailer\\Transport\\MailTransport::validate", "doc": "&quot;Validate this transport way&quot;"},
                    {"type": "Method", "fromName": "MimeMailer\\Transport\\MailTransport", "fromLink": "MimeMailer/Transport/MailTransport.html", "link": "MimeMailer/Transport/MailTransport.html#method_transport", "name": "MimeMailer\\Transport\\MailTransport::transport", "doc": "&quot;Messages sender : prepare the whole content and send the e-mail&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


