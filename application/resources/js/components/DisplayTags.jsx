import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { createUseStyles } from 'react-jss';

const DisplayTags = () => {
  const styles = useStyles();

  const options = [
    { label: 'Laravel', value: 'laravel' },
    { label: 'Vue', value: 'vue' },
    { label: 'PHP', value:  'php'},
    { label: 'API', value:  'api'}
  ];

  const status = [ 'invalid', 'active' ];

  const [ tags, setTags ] = useState([]);
  const [ articles, setArticles ] = useState([]);
  const [ busy, setBusy ] = useState(false);

  const getArticles = async() => {
    setBusy(true);
    const queryTags = tags.join(',');

    try {
      const req = tags.length > 0 ? await axios.get(`/articles/find/${queryTags}`)
        : await axios.get(`/articles`);

      if (req.status === 200) setArticles(req.data);
    } catch(err) {
      console.error(err);
    }

    setBusy(false);
  };

  const toggleOptions = (val) => {
    const tagSelected = tags.find((tag) => tag === val);
    let oTags = [...tags];

    if (tagSelected) {
      oTags.splice(tags.indexOf(val), 1);
      setTags(oTags)
    }
    else {
      oTags.push(val);
      setTags(oTags);
    }
  };

  useEffect(() => {
    getArticles();
  }, [ tags ]);

  const Article = (props) => {
    const item = props.item;
    return (
      <div className={styles.item}>
        <a href={item.url} target='_blank' className={styles.textTitle}>
          { item.title }
        </a>
        <div className={styles.textPlain}>{ item.comment }</div>
        <div className={`${styles.textPlain} ${styles.textCol2}`}>
          <span>{ item.tags.replace(/,/g, ', ') }.</span>
        </div>
        <div className={styles.textMini}>
          <span className={item.url_status === 1 ? styles.status1: styles.status0}>
            { status[item.url_status] } url
          </span>
        </div>
      </div>
    );
  };

  return (
    <div className={styles.container}>
      <h2>Links From Pinboard</h2>
      <div className={styles.textPlain}>Click tags to filter</div>
      <div className={styles.tagsButtons}>
        {
          options.map((opt) => {
            const selected = tags.find((t) => t === opt.value);
            return (
              <button
                key={opt.value}
                onClick={() => toggleOptions(opt.value)}
                className={`${styles.tags} ${selected ? styles.tagOn: styles.tagOff}`}
              >
                {opt.label}
              </button>
            )
          })
        }
      </div>
      {
        articles.length > 0 &&
        <p className={styles.item}>
          <b>
            {
              busy ? <i>Retrieving articles...</i>
              : `${articles.length} Articles found.`
            }
          </b>
        </p>
      }
      <div className={styles.items}>
        {
          articles.map((item) => {
            return (
              <Article item={item.attributes} key={item.id} />
            )
          })
        }
      </div>
    </div>
  );
};

const useStyles = createUseStyles({
  _flexed: { display: 'flex' },
  container: {
    display: 'flex',
    flexDirection: 'column',
    height: '100vh',
    padding: 25,
    width: 'calc(100%) - 50px'    
  },
  item: {
    borderRadius: 5,
    margin: '0 5px',
    padding: 10
  },
  status0: { color: 'gray' },
  status1: { color: 'green' },
  tagsButtons : {
    '& > :first-of-type': {
      marginLeft: 0
    }
  },
  tagOff: { backgroundColor: '#f1f1f1' },
  tagOn: { backgroundColor: '#0070f0', color:'#fff' },
  tags: {
    border: 'none',
    borderRadius: 5,
    cursor: 'pointer',
    margin: 5,
    padding: '10px 20px',
    '&:hover': {
      color: '#000',
      filter: 'brightness(80%)'
    }
  },
  textCol2: { color: '#bb0000' },
  textMini: {
    fontSize: 12
  },
  textPlain: {
    fontSize: 14
  },
  textTitle: {
    fontSize: 15
  }
});

export default DisplayTags;