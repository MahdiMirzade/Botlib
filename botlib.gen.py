"""
    This script is written to generate last `core.telegram.org`'s api library.
    I use this .py file to make a .php library, kinda stupid but I like it though :P
    > Install dependencies:
      $ pip install bs4 numpy html2text urllib3
    > Tested on: Python 3.9.0 / API 5.0

    Original repository for other stuff and maybe pull requests:
    github.com/mahdymirzade/lib
"""

# Importing Dependencies
import urllib.request, re, numpy, html2text
from bs4 import BeautifulSoup

# Reading telegram files to get methods and stuff
try:
    t = open("api.html").read()
except:
    urls = ["https://core.telegram.org/bots/api"]
    urllib.request.urlretrieve(urls[0], "api.html")
    print("Msg: Api file didn't exist, Downloaded to `./api.html`.")
    t = open("api.html").read()

# Getting telegram's manual methods from api.html
methods = re.findall("<i class=\"anchor-icon\"></i></a>(.*)</h4>\n<p>.* method .*</p>",t)

# Setting `functions` to an empty string
functions = ""

# Checking every single method in this `for` loop
for method in methods:
    # Skipping a none method
    if method == "Making requests when getting updates":
        continue
    # Extracting method's description to `des`
    des = str(re.findall(method+"</h4>\n<p>(.*)</p>",t)[0])
    des = html2text.html2text(des)
    des = des.replace("\n","")
    # Check if there is any paramteres for our method, 
    # if there wasn't, then it will make an empty function for method
    chk = re.findall(method+"</h4>\n<p>.*</p>\n<table class=\"table\">\n|"+method+"</h4>\n.*\n<blockquote>\n.*\n</blockquote>\n<table class=\"table\">\n",t)
    if not chk:
        func = "\t# " + des + "\n\tpublic function " + method + " () {\n"
        functions = functions + func + "\t\treturn $this->bot('" + method + "');\n\t}\n\n"
        continue
    # Extracting parameters' tables from `api.html` to extract parameters
    aftermetadata = re.split("/i></a>" + method + "</h4>",t)[1]
    table = re.split('<table class="table">',aftermetadata)[1]
    table = re.split('</table>',table)[0]
    # Setting an empty `tbodyex` array to store our `<td>` tags from parameters' table
    tbodyex = []
    # Parsing parameters' table from html and Extract `<td>` tags
    table2html = BeautifulSoup(table,"html.parser")
    tdbody = table2html.find_all('td')
    # Storing all `<td>` tags to `tbodyex`
    for td in tdbody:
        tbodyex.append(td)
    # Dividing `tbodyex` to a 4D,4D,... array ('Cause we have 4 columns in our parameters' table)
    parts = len(tbodyex)/4
    tbodyex = numpy.array(tbodyex, dtype=object)
    tbodyex = numpy.array_split(tbodyex,parts)
    func = "\tpublic function " + method + " ("
    tion = ""
    # Putting parameters' into a `for` loop
    for parameter in tbodyex:
        # Extracting parameter and its necessary
        para = re.sub("[\[\]\']|<td>|</td>","",str(parameter[0]))
        req = re.sub("<td>|</td>","",str(parameter[2]))
        # Setting two empty arrays to store, then sorting `impor-tent` and `not-im-portant`
        # parameters for upcoming work and stuff (we need to put required parameters first in the function's input)
        impor, notim = [], []
        if req == 'Yes':
            impor.append(para)
        else:
            notim.append(para)
        # Storing parameters as a `php function method ($parameters) { ` line to build our method's function
        for par in impor:
            func = func + "$" + par + ", "
        for par in notim:
            func = func + "$" + par + "=null, "
        # Storing parameters in function, in case to send method's data to bot() function
        tion = tion + "\t\t\t'" + para + "'" + " => " + "$" + para + ",\n"
    # Removing last two characters from `method ($parameters ` line to add `) {` to our line (characters were ', ')
    func = func[:-2]
    # Pasting Method's Description + `function method ($parameters)` line
    func = "\t# " + des + "\n" + func + ") {\n"
    # Pasting last function + new `function method ($parameters)` line + calling bot() function + defining data in the function
    functions = functions + func + "\t\treturn $this->bot('" + method + "', [\n" + tion + "\t\t]);\n\t}\n\n"

# Setting our file's first comments
php = '<?php\n/*\n * Telegram Bot Manual Library\n * Usage in hook.php file:\n * `require_once(\'botlib.php\');`\n * \n * Original repository for other stuff and maybe pull requests:\n * github.com/mahdymirzade/lib\n *\n */\n\n'

# Setting class, __cunstruct (to set bot's api key), bot() - Start of the library
start = 'class botlib {\n\n\t# Set botlib parameter to bot\'s api_key token\n\tpublic $token;\n\tpublic function __construct($token){\n\t\t$this->api_key = $token;\n\t}\n\n\t# Call methods with parameters, from api manual in a function named bot();\n\tpublic function bot($method,$datas=[]){\n\t\t$url = "https://api.telegram.org/bot".$this->api_key."/".$method;\n\t\t$ch = curl_init();\n\t\tcurl_setopt($ch,CURLOPT_URL,$url);\n\t\tcurl_setopt($ch,CURLOPT_RETURNTRANSFER,true);\n\t\tcurl_setopt($ch,CURLOPT_POSTFIELDS,$datas);\n\t\t$res = curl_exec($ch);\n\t\tif(curl_error($ch)){\n\t\t\tvar_dump(curl_error($ch));\n\t\t}else{\n\t\t\treturn json_decode($res);\n\t\t}\n\t}\n\n'

# Idk Comments or other functions? - End of the library
end = "}"

# Print out the file, you can store output to your own *.php file 
print(php + start + functions + end)
