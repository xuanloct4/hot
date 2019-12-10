import xmltodict
import pprint
import sys
import json
import urllib2

def fun(item):
    if '@translatable' in item.keys():
        if item['@translatable'] == 'false':
            return False
    return True

def transform(item):
    key = item['@name']
    value = item['#text']
    str = {}
    str[key] = value
    return str

def read_file(filename):
    # with open(filename) as fd:
    #     doc = xmltodict.parse(fd.read())
    #     return doc
    fd = urllib2.urlopen(filename)
    text = fd.read()
    doc = xmltodict.parse(text)
    return doc

def language_dict(list):
    nTranslatableList = filter(fun, list)
    l = map(transform, nTranslatableList)
    strings = {}
    for i in l:
        strings.update(i)
    return strings

def write_string_to_file(strings, filename):
    text_file = open(filename, "wt")
    n = text_file.write(strings)
    text_file.close()

if __name__ == '__main__':
    language = "en"
    version = "1.0.0"
    output = "output.json"

    print("Usage: python script.py <language> <version> <file1> <file2> <file3> ....")
    if len(sys.argv) < 4:
        exit(0);

    language = sys.argv[1]
    version = sys.argv[2]
    strings = {}
    for i in range(3, len(sys.argv)):
        doc = read_file(sys.argv[i])
        string = language_dict(doc['resources']['string'])
        strings.update(string)

    data = {language: strings}
    dict = {}
    dict["version"] = version
    dict["data"] = data
    write_string_to_file(json.dumps(dict), output)
