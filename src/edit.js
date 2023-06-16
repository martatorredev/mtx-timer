import { __, sprintf } from '@wordpress/i18n';

import { useSelect } from '@wordpress/data';
import { count as wordCount } from '@wordpress/wordcount';
import { useBlockProps } from '@wordpress/block-editor';

import './editor.scss';


export default function Edit() {

	const getCalculatedReadingTime = (content) => {
		const WORDS_PER_MIN = 255;
		const totalWords = wordCount(content, 'words');
		const rawTime = totalWords / WORDS_PER_MIN;
		let result = ['min (s)'];
		let time = Math.ceil(totalWords / WORDS_PER_MIN);
		result.push(time);
		if( rawTime < 1 ){

			time = Math.ceil( rawTime * 60 );
			result = ['sec (s)', time];

		}
		
		return result;
	}

	const readingTime = useSelect((select) => {
		const postContent = select('core/editor').getEditedPostAttribute('content');
		return getCalculatedReadingTime(postContent);
	});

	return (
		<p {...useBlockProps()}>
			{
				sprintf('%s %s of reading', readingTime[1], readingTime[0])
			}
		</p>
	);
}